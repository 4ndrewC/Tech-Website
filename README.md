# Tech-Website
_**Please read this stuff, it's quite important**_

**Public folder (frontend):**

Static files only (frontend js, css, etc.) all css and js files that you want to be connected to html (ejs) pages should be put into the public folder. Remember to use the correct directory when you link these files in the html.

**Views folder (frontend):**

Ejs is basically an html viewer because the express framework can't directly render an html file. The syntax in it is all the same as html, just different file format. 
If u wanna make a new html page, name it {something}.ejs, not .html

**Routes folder (backend):**

Folder for url routes, for example "domainname.cloud/home" or "domainname.cloud/submission".

Server.js runs the server, as shown in package.json "scripts" object

**Install node.js**

Everyone should install node js and npm (node package manager) on their own machines so they can test run the server themselves to see if stuff works. There are some specificalities with using express.js as a backend framework as opposed to using normal "require('http')" or something, so if something isn't working in the frontend, it may be because node.js doesn't allow certain things to work in the front end, for example using document.queryElement() when getting an html element or something like that.

In addition, github doesn't allow me to upload a folder with more than 100 files in it, so I can't upload all the node modules that come with starting an express.js app, so it would be better if u started an express app yourself on your own machine, and download all the files from this repository that isn't already in your express app. If u don't understand what I'm talking about, I can show u next Monday when we meet.

Starting an express.js app:

In your command prompt, run these commands (once you've downloaded node.js and npm)

npm init -y

npm install express

npm install nodemon

npm install ejs

nodemon is a dependency that allows the server to auto-restart when you make and save changes to your project
ejs is an html viewer, as explained earlier
npm init -y creates your package.json file
npm install express just starts an express app, including downloading all the node modules and stuff

**Using Github**

Last but not least, make pull requests to upload changes, cuz that's how github works. If u don't know how to use github, then look up a tutorial or learn from other members.
