SME 5.0 CMS 
==================
This is a light content management system for creating web sites different complexity.
The engine has high scalable modular structure. SME implements the MVC (Model-View-Controller) architectural pattern.

- website divides for Frontend and Backend
- editing content directly from Frontend Part
- internationalization
- XSLT templates

Installation
==================
As the site is dockerized. Yo need to install [docker](https://www.docker.com/)

- Download project from repository
```bash
git clone git@github.com:SergeyKoz/sme5.0-cms.git
```
- Run containers 
```bash
docker-compose up
```
- Load initial database 
```bash
docker exec -it sme50_database_1 bash -c "mysql -hlocalhost -udocker -pdocker sme_site < /docker-entrypoint-initdb.d/site.sql"
```

The website is allowed by address [http://127.0.0.1:8000](http://127.0.0.1:8000/)
The Backend is allowed by address [http://127.0.0.1:8000/extranet/](http://127.0.0.1:8000/extranet/)
- Login:admin
- Password:admin