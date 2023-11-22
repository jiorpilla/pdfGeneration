## pdfGeneration
A web application with asynchronous PDF generation
The aim of this task is to develop a web application using the Symfony 6 framework.
The application
should include the following functions:
#### Data management with a custom form 
    • Create a form that allows you to enter data for an entity of your choice.
    • When the form is submitted, a POST request should be triggered, resulting in the creation of a new entity.
#### Image upload functionality
    • The form should be able to upload multiple images.
    • These images must be assigned to the newly created entity.
#### Asynchronous PDF generation with message queue
    • Once the entity has been created, a PDF document containing the entered data and images should be generated. Please use the DOMPdf library for this.
    • The PDF should be generated asynchronously so as not to impair the user experience. Use a Message Queue Doctrine as the transport provider for this.
    • Once the PDF has been completed, it should be available for the user to download.
#### Code quality
    • Make sure your code is clean, well-structured and follows best practices.
#### Optional: Unit tests
    • If time remains, create unit tests for this usecase using PHPUnit to ensure the fun

To use this project :

    composer install
    yarn install

    add your DB settings in .env

    php bin\console doctrine:database:create
    php bin\console make:migration
    php bin\console doctrine:migrate

run this so that messenger is processed

    php bin\console messenger:consume async
    
packages i used:

###php


        "dompdf/dompdf": "^2.0",
        "symfony/webpack-encore-bundle": "^2.1",
        "vich/uploader-bundle": "*"


###javscript


        "@symfony/webpack-encore": "^4.5.0",
        "bootstrap": "^5.3.2",
    --dev
        "@popperjs/core": "^2.11.8",
        "jquery": "^3.7.1",
        "node-sass": "^9.0.0",
        "sass-loader": "^13.3.2"


