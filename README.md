# W.

Welcome! ^^

User Stories, Wireframes, and CMD >>> https://miro.com/app/board/o9J_kozA1bQ=/

Video Project Overview (in French) >>> https://www.loom.com/share/7592f32e85fd40b9a86ca71e7e4ed4d6

Video Demo Part 1 (in French) >>> https://www.loom.com/share/b72781c1053546ffaebe0ac8807b88c3

Video Demo Part 2 (in French) >>> https://www.loom.com/share/9afdeb5f924145b1906ed2efe078c3ff


# W. is a blog/oracle card reading based on Travis Scott Universe. 

To me, he's the only artist that has made the idea of a circus "sexy". Also we share a lot of common interests : like eclectic music, astrology, strong colors, bling bling and we both have deep fascination for the cosmos.
Also, Travis has a lot of awesome gifs and photos. Which I find very fun to work with.

In conclusion, W. is a tribute to our crazy worlds, not so far from each other. 


# What you can do with this web app:

AS AN USER:
- Login/Logout
- Register
- Access blog once you're logged in
- See the articles' blog ordered by publication date from the most recent
- See the articles by Themes: Music, Cosmos, Magic
- See an article with media links
- See comments from other users on each article + comment
- Be alerted when a new article has been posted
- Have a tarot reading online, with random rapper messages ^^
- Whether you're logged in or not, contact the W. team about any subject
- Put articles in your favorites

AS AN ADMIN:
- CRUD ARTICLE, USER, BLOG THEMES
- Moderation on users comments (update, delete)

# Later on:
- Music Player
- Change profile picture JS

### HOW TO INSTALL PROJECT

commands to run:
- git clone "project link"
- gco -b "your new branch Name"
- composer install
- php bin/console d:d:c
- php bin/console make:migration (!!! Before making a new migration, make sure the migrations file is empty. Otherwise, delete all the migrations.)
- php bin/console d:m:m
- php bin/console doctrine:fixtures:load --no-interaction
- symfony server:start -d // (so your server is running in the background, and you don't have to use an additional terminal)
  
  >>> Go to http://localhost:8000/ in your browser.
  
  With the fixtures, you should have all the data you need.
  Several Users + 1 Admin access. 
  All the access descriptions are in the fixtures file.
  
  
  # BYE
  
  I think that's it! Hope you'll enjoy :)



# Note to self:
- Embedding Controllers for categories in the navbar
- finish fetch favorites data on user profile
