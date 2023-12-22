# Alphacode

---

![](./frontend/img/projeto.png)

## Sobre

---

Este projeto é uma avaliação para teste de conhecimentos para uma vaga de emprego na empresa Alphacode.

## Tecnologias utilizadas

---

- PHP
- HTML
- CSS
- JavaScript
- JQuery 
- MySQL
- Bootstrap
- XAMPP
- Postman
- Composer

---

## Banco de dados

---

A seguir, está o script utilizado para a criação do banco de dados:

<pre>
```sql

create database db_alphacode;

use db_alphacode;

create table tbl_contatos (
	   id int not null auto_increment primary key,
       nome varchar(150) not null,
       data_nascimento date not null,
       email varchar(255) not null,
       profissao varchar(100) not null,
       telefone varchar(20) not null,
       celular varchar(20) not null,
       numero_whatsapp boolean not null,
       notificacao_email boolean not null,
       notificacao_sms boolean not null
);

```
</pre>


---