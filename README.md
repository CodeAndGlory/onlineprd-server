# OnlinePRD Server
- [Installation](#markdown-header-installation)
- [API endpoints](#markdown-header-api-endpoints)
    - [Index](#markdown-header-index)
        - [Pagination](#markdown-header-pagination)
        - [Filtering](#markdown-header-filtering)
        - [Relationships](#markdown-header-relationships)
            - [Nested relationships](#markdown-header-nested-relationships)
            - [Multiple relationships](#markdown-header-multiple-relationships)
            - [Specially defined relationships](#markdown-header-specially-defined-relationships)
        - [Revisions](#markdown-header-revisions)
    - [Show](#markdown-header-show)
        - [Showing relationships](#markdown-header-showing-relationships)
        - [Showing Revisions](#markdown-header-showing-revisions)
    - [Store](#markdown-header-store)
        - [Storing relationships](#markdown-header-storing-relationships)
    - [Update](#markdown-header-update)
        - [Updating relationships](#markdown-header-updating-relationships)
    - [Destroy](#markdown-header-destroy)

## Installation

First install the dependencies

```
composer install
```

Copy the .env file

```
cp .env.example .env
```

Fill in the missing values:
   - DB_DATABASE
   - DB_USERNAME
   - DB_PASSWORD
   - GOOGLE_CLIENT_SECRET

Generate your application key

```
php artisan key:generate
```

Run migrations

```
php artisan migrate
```
        
Fill in initial database values

```
php artisan db:initial-values
```

If you want to start out with some dummy data

```
php artisan db:seed
```

Create a public passport client (before passport:install)

```
php artisan passport:public
```
- Do this step before `passport:install` to ensure that your public client has the ID of 1

Install passport and generate keys

```
php artisan passport:install
```

Serve the application

```
php artisan serve
```

The virtual server must run on port 8001 for auth to work. To set the port manually, use 

```
php artisan serve --port=8001
```

## API Endpoints

To get a list of the available endpoints, you can use the `php artisan route:list` command.

All of the API endpoints have the `api/v1` prefix.

##### Each resource has endpoints for
- [Index](#markdown-header-index)
    - [Pagination](#markdown-header-pagination)
    - [Filtering](#markdown-header-filtering)
    - [Relationships](#markdown-header-relationships)
        - [Nested relationships](#markdown-header-nested-relationships)
        - [Multiple relationships](#markdown-header-multiple-relationships)
        - [Specially defined relationships](#markdown-header-specially-defined-relationships)
    - [Revisions](#markdown-header-revisions)
- [Show](#markdown-header-show)
    - [Showing relationships](#markdown-header-showing-relationships)
    - [Showing Revisions](#markdown-header-showing-revisions)
- [Store](#markdown-header-store)
    - [Storing relationships](#markdown-header-storing-relationships)
- [Update](#markdown-header-update)
    - [Updating relationships](#markdown-header-updating-relationships)
- [Destroy](#markdown-header-destroy)

### Index

```
GET http://localhost:8001/api/v1/users
```

#### Pagination

`GET /api/v1/users?skip=5&take=10`
will return the 6th through 15th records.

#### Filtering

`GET /api/v1/users?first_name=john` will return all users with the first name "John."

- Column names are in `snake_case`.
- The `filterable_columns` property of the model sets which columns the request may filter by.

#### Relationships

`GET /api/v1/departments?with=users`
will return all departments with a sub-array of their related users.

- Relationship names may be given in kebab-case, snake_case, or camelCase.

##### Nested Relationships

`GET /api/v1/departments?with=courses.offerings`
will return the offerings associated with a department through courses.

- The relationship path must be period delimited.

##### Multiple relationships

`GET /api/v1/departments?with=tags,courses.tags,courses.offerings.tags`
will return the departments with courses, offerings, and the tags associated with each department, course,
and offering.

- The list of relationships must be comma-delimited.
- Using multiple `with` values (ex: `?with=courses&with=tags`) will only recognize the last
value of with ("tags" in the previous example).

##### Specially defined relationships

Some models have a predefined set of relationships defined as the "relationships" property. These relationships act as
a shortcut which can be accessed by using `with=all` in the request. Using `with=all,tags` will include the tags
associated with all associated objects returned by the request.

#### Revisions

Use the revision_history relationship to access revisions for any model or nested relationship. For example,
`GET /api/v1/departments?with=revision_history,courses.offerings.revision_history`
will return all departments with `revision_history`, all related courses and offerings, and the `revision_history`
for all the retuned offerings.

Revisions are accessible through the `revision_history` property of the json object in the response.

### Show

```
GET http://localhost:8001/api/v1/users/{user_id}
```

Where `user_id` is the id of the user to be retrieved.

#### Showing relationships

Show requests handle relationships the same as index requests, described [above](#markdown-header-relationships).

#### Showing Revisions

Show requests handle revisions the same as index requests, described [above](#markdown-header-revisions).

### Store

```
POST http://localhost:8001/api/v1/users
first_name=John&last_name=Smith&email=example@example.com
```

Will create an object with the given values and store it in the database. Only columns in the `allowed_columns`
property of the object will be saved.

#### Storing relationships

Most relationships (many to one, one to many) may be set using the relationship_id column in the model to be
related. for example,

```
POST http://localhost:8001/api/v1/users
first_name=John&last_name=Smith&email=example@example.com&prefix_id=74 
```

Will create a new User and relate it to the prefix with ID 74.

For many-to-many relationships, the relationship may be updated from either model in the relationship, not just the 
model with the relationship_id field. In those relationships (department-user and permission-role), the name of the
relationship is a parameter that will accept a list of object IDs to be related.

```
POST http://localhost:8001/api/v1/departments
users=1,2,3
```

Will create a new Department and relate it to the Users with IDs 1, 2, and 3.

### Update

```
PUT http://localhost:8001/api/v1/users/{user_id}
first_name=James
```

Will update the user with the ID `user_id`. Only fields listed in the `allowed_columns` property of the object
may be updated.

To set a field to null, you may either leave the values blank (e.g. `first_name=`) or to the string 
`null` (case-sensitive, e.g. `first_name=null`).

#### Updating relationships

Relationships may be updated in the same way that they are stored, as defined
[above](#markdown-header-storing-relationships).

### Destroy

```
DELETE http://localhost:8001/api/v1/users/{user_id}
```

Will delete the user with the ID {user_id}
