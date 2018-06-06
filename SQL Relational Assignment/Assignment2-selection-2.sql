#1 Find the film title and language name of all films in which ADAM GRANT acted
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)

SELECT film.title, language.name FROM film 
    INNER JOIN language ON film.language_id = language.language_id 
    INNER JOIN film_actor ON film.film_id = film_actor.film_id
    INNER JOIN actor ON film_actor.actor_id = actor.actor_id
    WHERE actor.first_name = 'ADAM' AND actor.last_name = 'GRANT'
    ORDER BY title DESC;

#2 We want to find out how many of each category of film ED CHASE has started in so return a table with category.name and the count
#of the number of films that ED was in which were in that category order by the category name ascending (Your query should return every category even if ED has been in no films in that category).

SELECT category.name AS 'Film Category', IFNULL(categoryCounts.filmCounts, 0) AS 'Number of films ED CHASE performed in'
FROM category
LEFT JOIN (
    SELECT category.name AS categoryName, COUNT(film.film_id) as filmCounts
    FROM category
    INNER JOIN film_category
    ON film_category.category_id = category.category_id
    INNER JOIN film
    ON film.film_id = film_category.film_id
    INNER JOIN film_actor
    ON film_actor.film_id = film.film_id
    INNER JOIN actor
    ON actor.actor_id = film_actor.actor_id
    WHERE actor.first_name = 'ED' AND actor.last_name = 'CHASE'
    GROUP BY category.name
  ) AS categoryCounts
ON categoryCounts.categoryName = category.name;

#3 Find the first name, last name and total combined film length of Sci-Fi films for every actor
#That is the result should list the names of all of the actors(even if an actor has not been in any Sci-Fi films)and the total length of Sci-Fi films they have been in.


SELECT actor.first_name AS 'First Name', actor.last_name AS 'Last Name', SUM(film.length) AS 'Total length of Sci-Fi movies acted in'
FROM actor
INNER JOIN film_actor
ON film_actor.actor_id = actor.actor_id
INNER JOIN film
ON film.film_id = film_actor.film_id
GROUP BY actor.first_name, actor.last_name;


#4 Find the first name and last name of all actors who have never been in a Sci-Fi film

SELECT actor.first_name AS 'First Name', actor.last_name AS 'Last Name'
FROM actor
WHERE actor.actor_id NOT IN (
	SELECT DISTINCT actor.actor_id
	FROM actor
	INNER JOIN film_actor ON actor.actor_id = film_actor.actor_id
	INNER JOIN film ON film_actor.film_id = film.film_id
	INNER JOIN film_category ON film_category.film_id = film_actor.film_id
	INNER JOIN category ON category.category_id = film_category.category_id
	WHERE category.name = 'Sci-Fi'
);


#5 Find the film title of all films which feature both KIRSTEN PALTROW and WARREN NOLTE
#Order the results by title, descending (use ORDER BY title DESC at the end of the query)
#Warning, this is a tricky one and while the syntax is all things you know, you have to think oustide
#the box a bit to figure out how to get a table that shows pairs of actors in movies

SELECT first_movie.title AS 'Movies which both KIRSTEN PALTROW and WARREN NOLTE have acted in'
FROM(
	SELECT film.title, actor.first_name, actor.last_name 
    FROM actor 
    INNER JOIN film_actor ON actor.actor_id = film_actor.actor_id
    INNER JOIN film ON film_actor.film_id = film.film_id
    WHERE actor.first_name = 'KIRSTEN' AND actor.last_name='PALTROW'
    ) as first_movie

INNER JOIN
(
	SELECT film.title, actor.first_name, actor.last_name 
    FROM actor INNER JOIN film_actor ON actor.actor_id = film_actor.actor_id
    INNER JOIN film ON film_actor.film_id = film.film_id
    WHERE actor.first_name = 'WARREN' AND actor.last_name='NOLTE'
    ) as second_movie

ON first_movie.title = second_movie.title
ORDER BY first_movie.title DESC