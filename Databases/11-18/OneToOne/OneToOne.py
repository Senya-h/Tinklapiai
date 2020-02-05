import sqlite3
from User import User
from Address import Address


def open_connection():
    connection = sqlite3.connect("Library2.db")
    cursor = connection.cursor()
    return connection, cursor


def close_connection(connection, cursor, commit):
    if commit:
        connection.commit()

    cursor.close()
    connection.close()


def database_query(query, query_params=(), commit=True):
    try:
        connection, cursor = open_connection()
        cursor.execute(query, query_params)
    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection, cursor, commit)


def database_query_get_all(query, query_params=()):
    try:
        connection, cursor = open_connection()
        for row in cursor.execute(query, query_params):
            print(row)
    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection, cursor, False)


def database_query_get_one(query, query_params=()):
    try:
        connection, cursor = open_connection()
        cursor.execute(query, query_params)
        data = cursor.fetchone()
    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection, cursor, False)
        return data


def insert_user(user, address):
    database_query("""INSERT INTO Users (userId, email, fullName)
                              VALUES(?, ?, ?);""", (user.id, user.email, user.fullName,))

    address.userId = database_query_get_one("""SELECT userId FROM Users ORDER BY userId DESC LIMIT 1""")[0]
    user.id = address.userId
    database_query("""INSERT INTO Addresses (addressId, location, userId)
                          VALUES(?, ?, ?);""", (address.id, address.location, address.userId))

    user.addressId = database_query_get_one("""SELECT addressId FROM Addresses ORDER BY addressId DESC LIMIT 1""")[0]
    address.id = user.addressId
    database_query("""UPDATE Users SET addressId = (?) WHERE userId = (?) """, (user.id, address.id))


database_query("""CREATE TABLE IF NOT EXISTS Users (
                    userId INTEGER PRIMARY KEY AUTOINCREMENT,
                    email TEXT UNIQUE NOT NULL,
                    fullName TEXT NOT NULL,
                    addressId INTEGER REFERENCES Addresses(addressId)
                );""")

database_query("""CREATE TABLE IF NOT EXISTS Addresses (
                addressId INTEGER PRIMARY KEY AUTOINCREMENT,
                location TEXT NOT NULL,
                userId INTEGER REFERENCES Users(userId)
                );""")


new_user = User.User(None, "aerta@cawetaw.aery", "Saulius", None)
new_address = Address.Address(None, "Kaunas", None)

insert_user(new_user, new_address)

database_query_get_all("""SELECT * FROM Users""")
database_query_get_all("""SELECT * FROM Addresses;""")

database_query("DROP TABLE Users")
database_query("DROP TABLE Addresses")


