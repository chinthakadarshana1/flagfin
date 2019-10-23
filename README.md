# Project Title

Employee Review System

## Description

Employee Mangement and review system based on Service Oriented Architecture, OAuth2, .NET Core, PHP and Vue.JS.

## Demo

* [Web Application](http://emp.chinthakafernando.com)
```
User Name : chin
Password : user@123
```
* [API](http://ids.chinthakafernando.com)

## Built With

* [.NET Core](https://dotnet.microsoft.com/download) - The backend API framework
* [Vue.JS](https://vuejs.org/) - Front end framework
* [Codeigniter](https://codeigniter.com/) - MVM Server Framework based on PHP
* [Identity Sever](https://identityserver.io/) - Authentication Provider (OAUTH2)
* [MySQL](https://www.mysql.com/) - Database
* [Entity Framework Core](https://docs.microsoft.com/en-us/ef/core/) - ORM Framework


### Prerequisites

* .NET core 2.2
* PHP 7
* MySQL 5.7


## Getting Started

* Configure PHP and My SQL envirenment ([wamp server](http://www.wampserver.com/en/))
* Configure .NET Core Envirenment (IIS server or SelfHost)
* Change appsetting.json (Flagfin.CoreAPI project)
```
 "ConnectionStrings": {
    "AuthConnection": "server=localhost;database=flagfin;user=root;password="
  },
```
* Change config.php file (Flagfin.Web project) 
```
 $config['base_url'] = 'http://localhost:8081/Flagfin.Web/src';
```
* Update DB using Entity Framework (Visual Studio Package Manager Console)
```
 Update-Database
```

## Authors

* **Chinthaka Fernando**



