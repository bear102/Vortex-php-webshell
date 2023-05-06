# Vortex 


Vortex is a lightweight and customizable PHP webshell that provides an intuitive interface for executing system commands on a remote server. With its clean design and straightforward user interface, Vortex allows users to quickly and efficiently perform a variety of useful pentesting commands.

![vortex](https://github.com/bear102/Vortex/blob/main/img/vortex.png)


## Features

- Simple and easy-to-use interface
- execute commands in directory
- shows shell errors
- saves partial history
- automatic reverse shell
- automatic linPEAS install
- server information
- file upload

## Installation

To install Vortex on your server, simply copy the php file from [this link](https://github.com/bear102/Vortex/blob/main/vortex.php) and upload it to the server's web directory.

Next, navigate to the webshell URL in your browser and you should see the Vortex interface.

## Usage

**Command Execution**
Using the terminal in Vortex is easy. Simply type in a command in the prompt and hit enter. If you want to execute the command inside of a specific directory, fill out the execute in directory box and hit enter.

**Reverse Shell Connection**
To test for a reverse shell connection, put in your ip and port and hit execute. The code should automatically try tp execute many reverse shell commands until one works. Make sure you have your listener set up properly.

**LinPEAS Installation**
To install linpeas, simpily click the photo and linpeas will try to install itself as well as chmod +x the file. After it is complete, you can start a reverse shell and navigate to the temporary directory that it created. From there you can do ./linpeas.sh to run linPEAS.

**File Upload**
To upload a file, click the browse button and selected the desired file. Then hit upload. Vortex will attempt to upload your file into the current directory Vortex is running in.

## Contributing

If you find a bug or have a suggestion for Vortex, please submit an issue or a pull request on our [GitHub repository](https://github.com/bear102/Vortex).

## License

Vortex is licensed under the [MIT license](https://github.com/bear102/Vortex/blob/main/LICENSE).

