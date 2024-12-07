# DAW
# University project

```
1. Copy php files to /opt/lampp/htdocs/daw-project/
    $ sudo cp public/* /opt/lampp/htdocs/daw-project/
2. Start xampp (install from ./local-setup/)
    $ sudo /opt/lampp/manager-linux-x64.run
3. Test website
    http://localhost/daw-project/test.php
```

### Check xampp start/status
```
sudo /opt/lampp/lampp start
sudo /opt/lampp/lampp status
```
### Connect to mysql (default user / no password by default)

```
sudo /opt/lampp/bin/mysql -u root
```

### Update xampp htdocs with latest code 

```
sudo cp -r public/echonews/* /opt/lampp/htdocs/echonews/
```
