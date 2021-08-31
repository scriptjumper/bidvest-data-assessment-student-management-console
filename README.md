<p align="center">
  <h3 align="center">Student Management Console</h3>
</p>

## Table of Contents

- [About the App](#about-the-app)
  - [Built With](#built-with)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)

## About The APP

This app uses the command prompt or terminal to manage a students database by entering the required information about the student and saving it to a JSON file.

Here's why:

- Creating a JSON file with data based on a student 
- JSON files in stored in sub-directories under the `students/` directory
- Searching through sub directories to find the student's file by using any of the search params eg `id=1234567` or `name=nathan` or `surname=test` or `age=25` or `curriculum=math` (**Note:** search is not case sensitive)
- Editing Student data can be done and also keep previous details enter by leaving the input blank
- Deleting will remove the students file from the `students/` directory

### Built With

- [PHP](https://www.php.net/)

## Getting Started

> Here is a quick guide on how you can setup this APP on your machine.

### Prerequisites

Make sure you have the following install on your machine

- PHP

### Installation

1. Clone the repo

```shell
$ git clone https://github.com/scriptjumper/student-management-console.git
```

> Alternatively you can download the zipped files.

2. Launching the app

> When lauching this program there is 4 actions that is allowed

> `--action=add`: 
> This action is to create a Student's JSON file

```shell
$ php run.php --action=add
```

> `--action=search`: 
> This action will allow you to search through all the existing JSON files to match your search term

```shell
$ php run.php --action=search
```

> `--action=edit`: 
> This action is to update a Student's JSON file, just a note to ensure you pass the students id as well

```shell
$ php run.php --action=edit --id=1234567
```

> `--action=delete`: 
> This action is to delete a Student's JSON file, just a note to ensure you pass the students id as well

```shell
$ php run.php --action=delete --id=1234567
```