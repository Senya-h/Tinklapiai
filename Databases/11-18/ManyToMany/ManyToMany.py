import sqlite3
from ManyToMany.User import User
from ManyToMany.Address import Address


def open_connection():
    connection = sqlite3.connect("Library.db")
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

    row = database_query_get_one("""SELECT * FROM Users ORDER BY userId DESC LIMIT 1""")
    address.userId = row[0]

    database_query("""INSERT INTO Addresses (addressId, location, userId)
                          VALUES(?, ?, ?);""", (address.id, address.location, address.userId))


def manytomany_get_all():
    try:
        connection, cursor = open_connection()
        joinedQuery = """SELECT * FROM Users JOIN Addresses ON Users.userId = Addresses.addressId"""
        for userRow in cursor.execute(joinedQuery):
            print(userRow)

    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection, cursor, False)


database_query("""CREATE TABLE IF NOT EXISTS Users (
                    userId INTEGER PRIMARY KEY AUTOINCREMENT,
                    email TEXT UNIQUE NOT NULL,
                    fullName TEXT NOT NULL,
                );""")

database_query("""CREATE TABLE IF NOT EXISTS Addresses (
                addressId INTEGER PRIMARY KEY AUTOINCREMENT,
                location TEXT NOT NULL,
                );""")


database_query("""CREATE TABLE IF NOT EXISTS ManyToMany (
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  userId INTEGER REFERENCES Users(userId),
                  addressId INTEGER REFERENCES Addresses(addressId)
                  );""")


# new_user = User.User(None, "baerytae@vawt.ba ", "Sauliuxas", None)
# new_address = Address.Address(None, "Kretinga")
#
# insert_user(new_user, new_address)

# database_query("""INSERT INTO ManyToMany (userId, addressId) SELECT  (SELECT userId FROM Users WHERE fullName=(?)),
#                 (SELECT addressId FROM Addresses WHERE location=(?))""",
#                 (new_user.fullName, new_address.location,))

# database_query_get_all("""SELECT * FROM Users""")
# database_query_get_all("""SELECT * FROM Addresses;""")
manytomany_get_all()


