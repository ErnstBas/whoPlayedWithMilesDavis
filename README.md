# whoPlayedWithMilesDavis

<work in progress>

**Website**

Project that includes a PHP based webside, uses AJAX to dynamically update the page and a Postgresql database, to collect some of the musicians that played with Miles Davis.
Info and images are mostly taken from Wikipedia.

![image](https://user-images.githubusercontent.com/50556177/187842157-c1f9c222-6599-407a-99fd-2cdb01927124.png)

  
**CRUD functionality**

CRUD functionality added, although still some issues to solve. In short:
Albums, tracks and musicians can be created, read, updated and deleted.
  
Musicians

  ![image](https://user-images.githubusercontent.com/50556177/187842328-47e8ba7a-9ced-46b6-a896-fa2cf14b95a3.png)

  
  
Tracks
  
  
![image](https://user-images.githubusercontent.com/50556177/187843018-ff36fd4a-1e7b-4224-8e3b-9e631b82d59c.png)


  
Albums
  
  ![image](https://user-images.githubusercontent.com/50556177/187842796-b03f5ebb-f0e0-4d24-978d-e94779af5807.png)



Overview of the database (made with Lucidchart):

  ![image](https://user-images.githubusercontent.com/50556177/187844286-76b22364-8fd6-4310-a931-e80f2cb9ab26.png)


Importing a db.sql file:
```
psql -U username dbname < outfile.sql
```
                                     
