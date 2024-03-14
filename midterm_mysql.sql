CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author VARCHAR(50) NOT NULL
);

INSERT INTO authors (id, author) VALUES
(1, 'Patrick Henry'),
(2, 'Aristotle'),
(3, 'Thomas Jefferson'),
(4, 'George Washington'),
(5, 'Benjamin Franklin');

-- Create Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(20) NOT NULL
);

INSERT INTO categories (id, category) VALUES
(1, 'Success'),
(2, 'Attitude'),
(3, 'Leadership'),
(4, 'Motivational'),
(5, 'Positive');

-- Create Quotes Table
CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote TEXT NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO quotes (id, quote, author_id, category_id) VALUES
(1, 'The Bible is worth all the other books which have ever been printed.',1,2),
(2, 'The liberties of a people never were, nor ever will be, secure, when the transactions of their rulers may be concealed from them.',1,4),
(3, 'I know of no way of judging the future but by the past.',1,2),
(4, 'Give me liberty or give me death.',1,4),
(5, 'If this be treason, make the most of it!',1,4),
(6, 'Fear is the passion of slaves.',1,2),
(7, 'Love is composed of a single soul inhabiting two bodies.',2,5),
(8, 'Quality is not an act, it is a habit.',2,1),
(9, 'There is no great genius without some touch of madness.',2,2),
(10, 'Happiness depends upon ourselves.',2,3),
(11, 'I believe that every human mind feels pleasure in doing good to another.',3,4),
(12, 'I like the dreams of the future better than the history of the past.',3,5),
(13, 'Never spend your money before you have earned it.',3,1),
(14, 'In matters of style, swim with the current; in matters of principle, stand like a rock.',3,3),
(15, 'Honesty is the first chapter in the book of wisdom.',3,2),
(16, 'If the freedom of speech is taken away then dumb and silent we may be led, like sheep to the slaughter.',4,2),
(17, 'It is far better to be alone, than to be in bad company.',4,5),
(18, 'It is better to offer no excuse than a bad one.',4,1),
(19, 'Worry is the interest paid by those who borrow trouble.',4,5),
(20, 'Let us with caution indulge the supposition that morality can be maintained without religion. Reason and experience both forbid us to expect that national morality can prevail in exclusion of religious principle.',4,3),
(21, 'An investment in knowledge pays the best interest.',5,4),
(22, 'Well done is better than well said.',5,4),
(23, 'Tell me and I forget. Teach me and I remember. Involve me and I learn.',5,3),
(24, 'Some people die at 25 and are not buried until',5,5),
(25, 'The tragedy of life is that we get old too soon and wise too late.',5,3);