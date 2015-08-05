# Map Reduce in GO + PHP
Map Reduce - Programming model written in PHP with Go Lang to execute jobs in parallel on single cluster.

Jobs can be either:<br/>
1. HTTP/ API requests<br/>
2. Terminal commands<br/>

Currently [Mini Go Cluster](https://github.com/waqar-alamgir/mini-go-cluster) supports HTTP GET requests only.


## Setup
Run the following commands on Git Shell:
<br/><pre><code>git clone https://github.com/waqar-alamgir/map-reduce-go-php.git
git submodule foreach git pull</code></pre>


## Execute
Execute the process by running command like this (within the project directory):
<br/><pre><code>php .\src\bootstrap.php</code></pre>


## Usage
Use the process by running php commands like these:
<br/><pre><code>$mapper = new PushCampaignStatsMapper();
$reducer = new PushCampaignStatsReducer();
$params = array(
    'deviceType'=>'ios',
    'date'=>'20150629',
    'rePull'=>0,
    'partition'=>0,
    'directory' => 'push-stats',
    'jobPrefix' => 'ps'
);
$result = PushCampaignStatsJob::execute($mapper, $reducer, $params);
print_r($result); // [99900 , 100 , 10000]</code></pre>


## Output
Output of the program depends on how jobs are written.
For instance, following job example returns success and failed stats count for push message reports (sent to smart devices) by calling a report API.
Example output file:
<br/><pre><code>--------------------------------------------
Map Reduce in GO + PHP:
by Waqar Alamgir
--------------------------------------------
Simulated Final JSON output for job PushCampaignStatsJob:
Success Jobs  85179
Failed Jobs   14821
Job Execution 43/sec
--------------------------------------------
Took: 23.422 secs Memory: 1 MB</code></pre>


## Screenshot
![Cli output](https://raw.github.com/waqar-alamgir/map-reduce-go-php/master/screenshot/image.png)


## Configuration
You can modify the following config for number of jobs to execute parallel in GO:
<br/><pre><code>var MAX_CONCURRENT_CONNECTION = 10</code></pre>

While in PHP set your config params like this:
<br/><pre><code>Config::setValues(array(
    'go_push_stats_api' => 'http://127.0.0.1:82/map-reduce-go-php/test/TestApi.php?a',
    'go_push_script' => 'C:\\Go\\bin\\go.exe run',
));</code></pre>


## Future Development
As mentioned currently it supports HTTP GET requests. Later it is going to support POST, PUT and DELETE requests.
Terminal commands will also be supported by system.


## Developer Resources
Check out the URLs bellow to find out how its done:<br/>
[Go Lang Documentation and instalation](http://golang.org/)<br/>
[PHP](http://php.net/)<br/>


## Interested in contributing?
If you wanna add more features and user options then just fork this repo from the link bellow:
https://github.com/waqar-alamgir/map-reduce-go-php/fork


## Credits
Map Reduce in GO + PHP by [Waqar Alamgir](http://waqaralamgir.tk) [@wajrcs](http://www.twitter.com/wajrcs)