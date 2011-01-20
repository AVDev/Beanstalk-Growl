# Beanstalk-Growl
## Super Simple Growl Notifications for Beanstalkapp Deployments

##### Setup
Simply configure your Pre and Post deployment hooks up in beanstalk to point to this script passing along a GET variable called "hook". For example:

http://example.com/index.php?hook=pre
and
http://example.com/index.php?hook=post


##### Other stuff
I'm in no way taking any credit for class.growl.php which is used in this script. This was written by Tyler Hall (http://clickontyler.com/php-growl/).

