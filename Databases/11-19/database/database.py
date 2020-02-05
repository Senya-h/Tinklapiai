import sqlite3

from Order import Order
from Customer import Customer


def open_connection():
    connection = sqlite3.connect("Library.db")
    cursor = connection.cursor()
    return connection, cursor


def close_connection(connection):
    connection.commit()
    connection.close()


def create_table_customers():
    try:
        connection, cursor = open_connection()

        cursor.execute("""CREATE TABLE IF NOT EXISTS Customers (
                                    id integer PRIMARY KEY,
                                    name text,
                                    email text,
                                    address text,
                                    phone text,
                                    joinDate date,
                                    purchases integer,
                                    totalSpending numeric
                                    )""")
    except sqlite3.DatabaseError as error:
        print(error)

    finally:
        close_connection(connection)


def create_table_orders():
    try:
        connection, cursor = open_connection()

        cursor.execute("""CREATE TABLE IF NOT EXISTS Orders (
                            id integer PRIMARY KEY,
                            date datetime,
                            status text,
                            customer_id int references Customers(id),
                            price double)""")
    except sqlite3.DatabaseError as error:
        print(error)

    finally:
        close_connection(connection)


def insert_new_customer(customer):
    connection, cursor = open_connection()
    cursor.execute("""INSERT INTO Customers (name, email, address, phone, joinDate, purchases,
                        totalSpending)
                        VALUES(?,?,?,?,?,?,?)""", (customer.name, customer.email, customer.address, customer.phone,
                                                   customer.joinDate, customer.purchases, customer.totalSpending))

    close_connection(connection)


def insert_new_order(order):
    connection,cursor = open_connection()
    cursor.execute("""INSERT INTO Orders(date, status, customer_id, price)
                        VALUES(?, ?, ?, ?)""", (order.date, order.status, order.customer_id, order.price))

    close_connection(connection)


def get_all_customers():
    connection, cursor = open_connection()
    cursor.execute("SELECT * FROM Customers")

    data = cursor.fetchall()
    connection.close()
    return data


def get_all_orders():
    connection, cursor = open_connection()
    cursor.execute("SELECT * FROM Orders")

    data = cursor.fetchall()
    connection.close()
    return data


def get_customer_by_id(id):
    connection, cursor = open_connection()
    cursor.execute("SELECT * FROM Customers WHERE id = ?", (id,))

    return cursor.fetchone()[0]


def update_order_status(status, id):
    connection, cursor = open_connection()
    cursor.execute("""UPDATE Orders "
                   "SET status = ?,"
                   "WHERE id = ?""", (status, id))

    close_connection()


def clear_customers():
    connection, cursor = open_connection()
    cursor.execute("""DELETE FROM Customers""")
    close_connection(connection)


def clear_orders():
    connection, cursor = open_connection()
    cursor.execute("""DELETE FROM Orders""")
    close_connection(connection)


create_table_customers()
create_table_orders()

for i in range(6):
    new_customer = Customer.Customer("Saulius Rekasius", str(i) + "pastas@gmail.com", "Kaunas", "868493226",
                                     "2019-11-19", 0, 0)

    insert_new_customer(new_customer)


for i in get_all_customers():
    print(i)

for i in range(6):
    new_order = Order.Order("2019-11-19", "Processing", get_customer_by_id(i+1), (i+1) * 100)
    insert_new_order(new_order)


for i in get_all_orders():
    print(i)

clear_orders()
clear_customers()






