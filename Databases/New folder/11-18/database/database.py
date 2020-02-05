import sqlite3
from Book import Book
from Publisher import Publisher


def open_connection():
    connection = sqlite3.connect("Library.db")
    cursor = connection.cursor()
    return connection, cursor


def close_connection(connection):
    connection.commit()
    connection.close()


def create_delete_table(query):
    try:
        connection, cursor = open_connection()

        cursor.execute(query)
    except sqlite3.DataError as error:
        print(error)

    finally:
        close_connection(connection)


def get_data(query, query_params=()):
    try:
        connection, cursor = open_connection()
        cursor.execute(query, query_params)
        data = cursor.fetchall()
        connection.close()
        return data
    except sqlite3.DataError as error:
        print(error)
    finally:
        connection.close()


def update(query, query_params):
    try:
        connection, cursor = open_connection()
        cursor.execute(query, query_params)

    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection)


def calculate_profit(book):
    connection, cursor = open_connection()
    cursor.execute("""SELECT SUM(copies_sold * selling_price) -  SUM(printed_quantity * printing_price) FROM publishers
                    LEFT JOIN books
                    ON books.book_title = publishers.book_title
                    WHERE ? = publishers.book_title""", (book.title,))
    data = cursor.fetchone()
    connection.close()
    print(data)


def create_book(book):
    query = "INSERT INTO books VALUES(?,?,?,?,?,?,?)"
    query_params = (book.id, book.title, book.author, book.publish_date, book.publisher,
                   book.selling_price, book.copies_sold,)
    database_query(query, query_params)


def database_query(query, query_params):
    try:
        connection, cursor = open_connection()
        cursor.execute(query, query_params)
    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection)


def filter_by_author_date(author, date): #filtruoja pagal autoriu ir leidimo data
    connection, cursor = open_connection()
    query = """SELECT * FROM books WHERE author = ? AND publish_date < ?"""
    query_params = (author, date)
    cursor.execute(query, query_params)
    data = cursor.fetchall()
    connection.close()

    print(*data, sep="\n")



new_book1 = Book.Book(None, "Haris Poteris", "J. K. Rowling", "2010-10-10", "Publisher1", 15.15, 8000)
new_book2 = Book.Book(None, "Haris Poteris 2", "J. K. Rowling", "2012-10-10", "Publisher1", 15.15, 9000)
new_book3 = Book.Book(None, "Haris Poteris 3", "J. K. Rowling", "2015-10-10", "Publisher2", 10, 1000)
new_book4 = Book.Book(None, "Hipis", "Autorius", "2010-11-25", "Zebras", 15, 10)

new_publisher1 = Publisher.Publisher(None, "Publisher1", "Haris Poteris", "J. K. Rowling", 7000, 4)
new_publisher2 = Publisher.Publisher(None, "Publisher1", "Haris Poteris 2", "J. K. Rowling", 10000, 5)
new_publisher3 = Publisher.Publisher(None, "Publisher2", "Haris Poteris 3", "J. K. Rowling", 1000, 5)
new_publisher4 = Publisher.Publisher(None, "Zebras", "Hipis", "Autorius", 200, 10)

create_delete_table("""CREATE TABLE IF NOT EXISTS books (
                    id integer PRIMARY KEY,
                    book_title text unique,
                    author text,
                    publish_date date,
                    publisher text,
                    selling_price double,
                    copies_sold integer
                    )"""
)

create_delete_table("""CREATE TABLE IF NOT EXISTS publishers (
                    id integer PRIMARY KEY,
                    publisher_name text,
                    book_title text unique,
                    author text,
                    printed_quantity integer,
                    printing_price double
                    )"""
)

create_book(new_book1)

data = get_data("SELECT * FROM books")

print(data)

create_delete_table("DROP TABLE books")





