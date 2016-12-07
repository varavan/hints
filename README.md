# Hints

This tool is made for sharing knowleage on php projects where more than one developer is working. 
Have you ever found yourself trying to fix something for ages, then someone else tell you an small hint that makes you resolve it within minutes? 
That is the purpose for of this project. To have a set of hints that can be easily add or shown from your terminal. 
 
# Installation

Install it via composer with `composer require varavan/hints`

# Usage

There is an entry point for the application which is the file `hints`. After the installation you can call it via `vendor/varavan/hints/hints` As long as this project is thought to be implemented on php projects, the app is written on php. 

I would encourage you to create a symlink between the executable file `hints` and your `bin` folder. So it is easier to include `hints` on your project

I would advice you to call `hints` command on `composer` `post-scripts`, so everyone can refresh thoose knowleage pills on every vendor updates

Please notice that the storage for this application is a file called `hints.json` that will be versioned

**adding hints**
`hints add 'content of the hint'` 
- option to add some author metadata --author 'AUTHOR NAME'
- option to add some tags as metadata --tags 'ADD TAGS SEPARATE BY COMMA'
- option to point a file --file-path 'FILE_PATH_FOR_CONTENT_RELATED'
- option to point a line --file-line 'FILE_LINE'

**listing hints**
`hints show` 
- option to filter by tags --tags 'tag'
- option to filter by author --author
- option to filter by file --file-path
- option to set up a limit  (by default 1) --limit


For example `hints show --author 'Jhon Doe' --tags 'set-up,init' --limit 15`
 

# Status

This library is still on an early development. You can find some bugs and errors on it. Please report it :)