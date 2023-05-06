# Vortex 


Vortex is a versatile and easy-to-use PHP webshell that allows remote execution of system commands. Its customizable and lightweight design provides a clean and intuitive interface for performing a variety of pentesting commands. With Vortex, users can efficiently and securely navigate through the server file system, test for reverse shell connections, install linPEAS, upload files, and much more.

<img width="681" alt="vortex" src="https://user-images.githubusercontent.com/58755251/236601239-b2352905-f3f7-4bfa-bae5-59634e72c170.png">


## Features

- Simple and easy-to-use interface
- execute commands in directory
- shows shell errors
- saves partial history
- automatic reverse shell
- automatic linPEAS install
- server information
- running application information
- file upload




## Installation

To install Vortex onto a server, simply copy the php file from [this link](https://github.com/bear102/Vortex/blob/main/vortex.php) and upload it to the server's web directory.

Next, navigate to the webshell URL in your browser and you should see the Vortex interface.

<br><br>


## Usage

**Command Execution**
Using the terminal in Vortex is easy. Simply type in a command in the prompt and hit enter. If you want to execute the command inside of a specific directory, fill out the execute in directory box and hit enter.

**Reverse Shell Connection**
To test for a reverse shell connection, put in your ip and port and hit execute. The code should automatically try to execute many reverse shell [commands](https://github.com/swisskyrepo/PayloadsAllTheThings/blob/master/Methodology%20and%20Resources/Reverse%20Shell%20Cheatsheet.md) until one works. Make sure you have your listener set up properly.

**LinPEAS Installation**
To install linpeas, simpily click the photo and [linpeas](https://github.com/carlospolop/PEASS-ng) will try to install itself as well as chmod +x the file. After it is complete, you can start a reverse shell and navigate to the temporary directory that it created. From there you can do ./linpeas.sh to run linPEAS.

**File Upload**
To upload a file, click the browse button and selected the desired file. Then hit upload. Vortex will attempt to upload your file into the current directory Vortex is running in.




## Contributing

If you find a bug or have a suggestion for Vortex, please submit an issue or a pull request on our [GitHub repository](https://github.com/bear102/Vortex).




## License

Vortex is licensed under the [MIT license](https://github.com/bear102/Vortex/blob/main/LICENSE).

