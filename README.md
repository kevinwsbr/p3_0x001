# Well, what's iFace?

iFace is a fictional social network written in PHP and created as the first project of the discipline of **Project of Software**.

## What an user can do?

- Register and login/logout
- Add another users as friends
- Edit their profile data (name, username, e-mail, etc)
- Send private messages to other members and public messages for communities
- Create communities (groups) and manage their members
- Enter public communities (groups)
- View users profile and communities page
- Delete your account

## Dependencies

- MySQL Server
- PHP 7.0+

## Right, and how to build that?

First, clone this repository. Open the repository folder and navigate to `docs/` and import `db.sql` (or `db_with_some_data.sql`) file to your MySQL Server instance. After that, navigate to `src/` folder and execute the PHP built-in server:

```bash
php -S localhost:<port>
```

Finally, open `localhost:<port>` on your browser.

## Screenshots

You cand find some screenshots of this application running under the `docs/screenshots` folder.

## License

This project is licensed under the MIT License.
