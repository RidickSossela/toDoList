Clonar o repositorio:
    git clone https://github.com/RidickSossela/toDoList.git

    Renomeie o arquivo ".env.exemple para ".env"

    Entre na pasta do projeto para instalar as dependencias:
        composer install

    Gerar a Key do laravel
        php artisan key:generate


    Abra o arquivo ".env" e configure o bando de dados Mysql

    No banco de dados Mysql crie uma base de dados com o mesmo nome configurado no arquivo ".env"

    Para criar as tabelas rode o comando
        php artisan migrate