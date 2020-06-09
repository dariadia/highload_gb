##### 1. Установить Zabbix Server.
По методичке не вышло, поставила по руководству с zabbix.com на рабочем ноутбуке. Личный долго возмущался ошибками на php и правам БД.

##### 2. Добавить шаблон мониторинга HTTP-соединений.
Через веб интерфейс, согласно [докам](https://www.zabbix.com/documentation/4.0/manual/web_monitoring)

Настройка → Узлы сети (или Шаблоны)
Веб в строке с узлом сети/шаблоном -> Создать сценарий
Параметры сценария
Ещё есть вкладка Шаги – настроить шаги веб-сценария

##### 3. Настроить мониторинг созданных в рамках курса виртуальных машин.

Прописать конфиг так, чтобы мы могли посмотреть статистику через NGINX Status Page:
`/etc/zabbix/zabbix_agentd.conf`

location = /basic_status {
    stub_status on;
    allow 127.0.0.1;
    deny all;
}

Открыть `http://localhost/basic_status` и увидим:

Active connections: 1 
server accepts handled requests
3 3 2 
Reading: 0 Writing: 1 Waiting: 0 

Дальше запускаем шаблон мониторинга из прошлого пункта дз и смотрим Zabbix, что 
```
    Zabbix server is running	Yes	localhost:10051
    Number of hosts (enabled/disabled/templates)	148	2 / 0 / 146
    Number of items (enabled/disabled/not supported)	171	159 / 0 / 12
    Number of triggers (enabled/disabled [problem/ok])	96	96 / 0 [0 / 96]
    Number of users (online)	2	1
```

##### 4.* Добавить шаблон мониторинга NGINX.
Взяла [отсюда](https://www.zabbix.com/integrations/nginx) и запустила
