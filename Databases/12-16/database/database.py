import sqlite3
from Author import Author
from Book import Book

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


def database_query_print(query, query_params=()):
    try:
        connection, cursor = open_connection()
        for row in cursor.execute(query, query_params):
            print(row)
    except sqlite3.DataError as error:
        print(error)
    finally:
        close_connection(connection, cursor, False)


def insert_new_author(author, book):
    database_query("""INSERT INTO Books (bookId, bookTitle, author)
                                  VALUES(?, ?, ?);""", (book.bookId, book.bookTitle, book.author,))

    book.bookId = database_query_get_one("""SELECT bookId FROM Books ORDER BY bookId DESC LIMIT 1""")[0]
    author.bookId = book.bookId

    database_query("""INSERT INTO Authors (authorId, author, bookId)
                              VALUES(?, ?, ?);""", (author.authorId, author.author, author.bookId))

    author.authorId = database_query_get_one("""SELECT authorId FROM Authors ORDER BY authorId DESC LIMIT 1""")[0]



database_query("""CREATE TABLE IF NOT EXISTS Books (
                  bookId INTEGER PRIMARY KEY AUTOINCREMENT,
                  bookTitle TEXT NOT NULL,
                  author TEXT NOT NULL
                  )""")

database_query("""CREATE TABLE IF NOT EXISTS Authors (
                  authorId INTEGER PRIMARY KEY AUTOINCREMENT,
                  author TEXT NOT NULL,
                  bookId INTEGER REFERENCES Books(bookId)
                  )""")

# new_book = Book.Book(None, "Metro", "Autorius1")
# new_author = Author.Author(None, "Autorius1", None)
#
# insert_new_author(new_author, new_book)

# database_query("CREATE VIEW AuthorBooks AS SELECT * FROM Authors JOIN Books ON Books.bookId = Authors.authorId;")
# database_query("ALTER TABLE Books ADD Pages SMALLINT NOT NULL DEFAULT 0")
# database_query("UPDATE Books SET Pages = 50 WHERE bookId = 1")
database_query_print("SELECT * FROM AuthorBooks")


# database_query("DROP TABLE Authors")
# database_query("DROP TABLE Books")
# database_query("DROP VIEW AuthorBooks")

