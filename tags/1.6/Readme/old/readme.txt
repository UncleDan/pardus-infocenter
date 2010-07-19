Pardus Infocenter v1.5b2.003

1. About
This tool is designed for sharing bulletin board missions, combat logs and hacks between alliance members. It consists from two parts: website and greasemonkey scripts. Website is written in php and is supposed to be installed by IT-responsible alliance member. GM scripts can be easily installed by other alliance members in Firefox of Opera. This tool was previously known as Combat Logger and was written in asp and now is ported to php.

2. Installation notes
Installation of the website is straight and forward for anyone familiar with php:
* create new database and run /mysql/db.sql in phpadmin
* specify database connection properties in website/modules/settings_mod.php
* copy content of /infocenter folder to the /htdocs/pardus/infocenter on your php host
* edit servers variable at the top of GM scripts, copy scripts to /htdocs/pardus/gmscripts and supply your alliance members with download links
2.1 Migration from Pardus Logger.
After installing the Infocenter you might want fill it with data from Pardus Logger:
* download the access database file (pcl.mdb) from your host
* open it in Access and right click combat table and select "Export..."
* in the export dialog select "Text files" for "save as type"
* press "Export" and then "Advanced..." button
* change "Date Order" to "YMD", "Date Delimiter" to "-" and check "leading zeros in dates"
* press "Ok" and "Finish"
* in phpadmin open combat table and click "Import"
* select the text file you imported, check "CSV" in "Format of imported file" section and proceed
* because of difference in time zones between your PC and sql server, dates in the imported data may be shifted by few hours. Use sql to update all date field if necessary
* repeat export/import procedure for hack table

3. Disclaimer
The Pardus Infocenter is distributed "as is". No warranty of any kind is expressed or implied. You use at your own risk. The author will be not liable for your hard drive was formatted, your cat died or any other kind of loss while using or misusing this tool.

4. Contact
PM Uncledan in Orion universe or send email uncledan@uncledan.it (previous maintainer Pio -Orion- siur2@yahoo.com)

5. Known bugs / Todo list
* Missions are shared even if permissions would not allow
* Users administration page
* Use the defined variable DB_TABLE_PREFIX to make customization easier