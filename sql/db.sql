-- preset sql command for creating all the books information in the database

CREATE TABLE users(
    user_id VARCHAR(20) PRIMARY KEY,
    password VARCHAR(20) NOT NULL
);

CREATE TABLE carts(
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    user_id VARCHAR(20) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (book_Id) REFERENCES books(book_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)

CREATE TABLE books(
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(100) NOT NULL,
    publisher VARCHAR(50) NOT NULL,
    category VARCHAR(50) NOT NULL,
    lang VARCHAR(50) NOT NULL,
    author VARCHAR(100) NOT NULL,
    description VARCHAR(300) NOT NULL,
    price INT NOT NULL,
    published VARCHAR(50) NOT NULL,
    new_arrival BIT NOT NULL
)


ALTER TABLE books CHANGE new_Arrival new_arrival VARCHAR(50)

-- 1 
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('The Creature Choir', 'HarperCollins Publishers', "Storybook", "English",
  "David Walliams", "Sing your heart out with a whole choir of characters, in the showstopping new picture book from number one bestselling author David Walliams, illustrated by the artistic genius, Tony Ross!",
  117, "United Kingdom, 12 December 2019", 1);

-- 2
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Olive, Again', 'Penguin Books Ltd', "Contemporary Fiction", "English",
  "Elizabeth Strout", "An extraordinary new novel by the Pulitzer Prize- winning, Number One New York Times bestselling author of Olive Kitteridge and My Name is Lucy Barton...",
  122, "United Kingdom, 31 October 2019", 0);

-- 3
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Have You Filled A Bucket Today? : A Guide to Daily Happiness for Kids', 'Bucket Fillosophy', "Picture Book", "English",
  "David Messing", "Children are not the only ones that need to learn how to be truly happy. It's all in the bucket, that invisible bucket that follows you everywhere... teaches young readers valuable lessons about giving, sharing, and caring...",
  73, "USA, 1 October 2015", 0);

-- 4
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Dog Man: World Book Day 2020 (50CP)', 'Scholastic', "Storybook", "English",
  "Dav Pilkey", "A BRILLIANT new DOG MAN book for World Book Day 2020 packedwith three humorous stories. Dav Pilkey's wildly popular DOG MAN series appeals to readers of all ages and explores universally positive themes...",
  50, "United Kingdom, 27 Feb 2020", 0);

-- 5
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Brave Irene: A Picture Book', 'Square Fish', "Picture Book", "English",
  "William Steig", "Brave Irene is Irene Bobbin, the dressmaker's daughter. Her mother, Mrs. Bobbin, isn't feeling so well and can't possibly deliver the beautiful ball gown she's made for the duchess to wear that very evening.",
  87, "USA, 1 January 1996", 0);

-- 6
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Stanley Elwin & Alisdair Gray J15/2', 'Dalkey Archive Press', "Contemporary Fiction", "English",
  "Review of Contemporary Fiction", "Arthur M. Saltzman, Stanley Elkin: An Introduction/Peter J. Bailey, 'A Hat Where There Never Was a Hat': Stanley Elkin's Fifteenth Interview/Stanley Elkin, Words and Music/William Gass, Stanley Elkin: An Anecdote/Jerome Charyn...",
  139, "United States, 8 January 1995", 0);

-- 7
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('The Rule of the Land', 'Faber & Faber; Main edition', "History", "English",
  "Garrett Carr", "In the wake of the EU referendum, the United Kingdom's border with Ireland has gained greater significance: it is set to become the frontier with the European Union. Over the past year, Garrett Carr has travelled this border...",
  130, "United Kingdom, 1 May 2017", 0);

-- 8
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('The Story of the Holy Land', 'Lion Books', "History", "English",
  "Peter Walker", "This is a highly illustrated, visually led guide through the story of the Holy Land, from Bible times to the present day. The Holy Land frequently features in today's headlines as a much fought-for territory.",
  199, "United Kingdom, 22 June 2018", 0);

-- 9
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Doctor Who', 'BBC Books', "Storybook", "English",
  "Terrance Dicks, Matthew Sweet, Simon Guerrier, Colin Baker", "In this exciting collection you'll find all-new stories spinning off from some of your favourite Doctor Who moments across the history of the series. Learn what happened next, what went on before...",
  149, "United Kingdom, 24 October 2019", 0);

-- 10
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Festivals of Love', 'Createspace Independent Publishing Platform', "Contemporary Fiction", "English",
  "Midwest Fiction Writers", "Minnesota: A state blessed with 10,000 lakes, four beautiful seasons, and countless romantics looking for love in all the right places! What better place to find a perfect happily-ever-after than one of Minnesota's uniquely fun...",
  131, "United States, 1 May 2016", 0);

-- 11
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('The Jungle Book', 'Palazzo Editions Ltd', "Picture Book", "English",
  "Rudyard Kipling", "Originally published as part of Kipling's famous The Jungle Book, the story of Rikki Tikki Tavi, the little mongoose rescued by a family when he was half-drowned in a storm, has been an enduring favourite with young and old for more than half a century.",
  80, "United Kingdom, 1 September 2018", 0);

-- 12
INSERT INTO
  `books` (book_name, publisher, category, lang, author, description, price, published, new_arrival)
VALUES
  ('Sapiens', 'Vintage Publishing', "History", "English",
  "Yuval Noah Harari", "THE MILLION COPY BESTSELLER Fire gave us power. Farming made us hungry for more. Money gave us purpose. Science made us deadly. This is the thrilling account of our extraordinary history - from insignificant apes to rulers of the world.",
  103, "UK, 29 April 2015", 0);
