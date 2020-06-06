###### 1. Построить NGINX-балансировку между двумя виртуальными машинами. Доказать, что балансировка происходит.

Config

```
log_format upstream '$remote_addr - $host [$time_local] "$request" '
    'request_length=$request_length '
    'status=$status bytes_sent=$bytes_sent '
    'body_bytes_sent=$body_bytes_sent '
    'referer=$http_referer '
    'user_agent="$http_user_agent" '
    'upstream_status=$upstream_status '
    'request_time=$request_time '
    'upstream_response_time=$upstream_response_time '
    'upstream_connect_time=$upstream_connect_time '
    'upstream_header_time=$upstream_header_time';


upstream cache-api {
    ip_hash;
    server 10.32.18.7:8080 max_fails=2 fail_timeout=10s;
    server 10.32.18.6:8080 max_fails=2 fail_timeout=10s;
}

server {
    listen 443 ssl http2;
    server_name cache-api.sample.com;
    access_log /var/log/nginx/cache-api-access.log upstream;
    error_log /var/log/nginx/cache-api-error.log;

    ssl_certificate /etc/ssl/sample.com.crt;
    ssl_certificate_key /etc/ssl/sample.com.key;

    root /var/www/html;

    location / {
        proxy_pass http://cache-api/;
        proxy_read_timeout 15;
        proxy_connect_timeout 3;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Real-IP $remote_addr;
    }
}

```

###### 2. Реализовать альтернативное хранение сессий в Memcached.
php.ini

```
session.save_handler = memcached
session.save_path = "127.0.0.1:11211"
;session.save_path = "tcp://127.0.0.1:11211"
```

###### 3. Настроить NGINX для работы с символьной ссылкой.

a.mysite.local nginx
```
root /var/www/sym.mysite.local;
```

```
sudo ln -s a.mysite.local sym.mysite.local
```
