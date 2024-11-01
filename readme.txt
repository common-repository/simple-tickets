=== Simple Tickets ===
Contributors: P E S Grimes
Tags: Tickets, Ticket System, Simple Tickets, Ticketing, Ticket Managing System, Support Tickets, Help desk
Donate link: http://simple-tickets.com
Requires at least: 4.4.2
Tested up to: 5.5.1
Stable tag: 5.2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Simple Tickets consists of New Ticket Form, Settings and Ticket List. With these base features you can manage each ticket and change specific fields.

SimpleTickets has been tested on WordPress 5.5.1 and PHP 7.3 Please report any errors giving the full description of the problem and include your wordpress and PHP versions, this will assist us in replicating the fault or error.

Welcome to this release of simple tickets, help desk or even project management (you decide)! the sparseness of functionality and options in the GUI is intentional to make the plugin as simple and easy to use as possible hence "Simple Ticketing".

On this update we have not changed the basic operation of your tickets or improved the interface GUI, we have upgraded the code to work with PHP 7.2 as there is a big move over to this now, and tested it on the most recent version of wordpress to check compatibility.

However, we are adding additional features so you can select how you want your ticket system set up. Obviously, the more you load into it the more complicated it becomes for others to use it so we took it back to real basics. Furthermore, if you are willing to advance your 'Simple Tickets' all you have got to do is switch on Advanced Features.

if you are interested in having options for independent users on each multisite please inform us.

Your feedback and suggestions "ARE" important therefore If you download this plugin and use it please give us feedback so we can improve this plugin for you, any wacky ideas welcome :)

Developers Contributions By:
Mr P Grimes.
Naeem Malik.

= Short list of features =
* Requires Virtually no configuration!
* Manipulate the settings for each ticket
* No setup is necessary although fine tuning available!
* Don't forget that we are trying to advance this plugin all the time!
* Change the time that a user has to wait before creating a new ticket
* Simple to follow Ticket List. you can click on a ticket to go into it
* Can create tickets through a page or directly through the 'New Ticket' tab
* Simple creation of new ticket from short code which you paste on any page i.e. [GBL_SMTCKS]
* It is easy to understand and simple to follow
* List tickets on front end GUI!
* Create/Edit tickets so they are sticky!

= Flexibility =
* Can be used as a Helpdesk
* Can be used for Project Management
* Can be used as a Ticket Support System

== Installation ==
1. Upload to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. And your done.

== Frequently Asked Questions ==
= How do I display New Ticket Form on my WordPress page? =
In order to display New Ticket Form, you need to add [GBL_SMTCKS] on a specific page and after saving the page it should appear on it after refresh.
You can set [GBL_SMTCKS type=clear] if you would like to use our css formatting of the new ticket form.

= Displaying Tickets on front end? =
Since the version 1.6.5 now this is possible! Simply use [GBL_SMTCKS_LIST] to display the Ticket List on the front end. do [GBL_SMTCKS_LIST type=clear] to use our css formatting to it.
Bare in mind you can only list tickets on the front end but users cannot go into a ticket and/or modify them; this can only be done through the administrator panel.

= I can't create a new ticket? =
Yes you can, either through the Simple Tickets panel in the WP-admin Simple Tickets > New Ticket or through the website page you pasted the [GBL_SMTCKS] to.
Don't forget when you're finished writing up the ticket to click the button 'Create Ticket'!
If you are trying to create a ticket through a page then don't forget to meet the criteria.

= I got a notification 'Your ticket has been created.' but I can't see my ticket =
Yes you can if you are the website administrator. It is in Simple Tickets > Ticket List.
If you are not an administrator then you can't see your ticket but if the website asks you for your email then the administrator might contact you through it.

= I'm in a ticket, what can I do? =
If you're in a ticket, you can go back to the ticket list by clicking 'Back to Ticket List' or go to the previous ticket by clicking 'Previous Ticket' button (if displayed at the top) or you can go to the next ticket if button 'Next Ticket' is displayed at the top.
After the buttons you will get a Settings Panel on the left which allows you (administrator) to edit all the user settings give like their email, name etc. You can update these by clicking Update Settings.
If you want to comment on the ticket you can click in the 'Your new comment here' area an type in your comment. After you have finished typing it in then you can click 'Create Comment' button in order to create the comment.
If you want to edit a ticket then you can click on the Edit button next to #1 | Date by user. or if you want to delete the ticket you can click delete button which is next to Edit or if you want to move this ticket into a different category you can click move which is next to delete.
Don't forget that Edit | Delete and Move. On top of this, the move feature is only available if you are registered with us.

= Okay, I know how to edit a ticket but, how do I edit a comment? =
Same applies to comments as to ticket but the delete button doesnt delete the ticket now, it deletes the specified comment.

= I get an error saying 'This ticket does not exist.' when I try to view a ticket =
If you are getting this error it either means that the ticket doesn't exist or one of the ticket files is corrupted. To find out more contact us through http://simple-tickets.com/contact/

= How do I change the time the user has to wait after creating a ticket in order to create the next one? =
You have to go into Simple Tickets > Settings and at the top you will get 'Time the user has to wait after creating a ticket in order to create the next one:' and the value will be set to 5 minutes by default, you can change this and click Save and it will save.

= How do I change the minimum amount of characfters for a new ticket details? =
Same as to one above, 25 is set by default.

= What does Label stand for in Advanced Features Simple Tickets > Settings? =
Label stands for the display name of the field, so if you change Your name to e.g. 'How old are you?' this will get displayed in new ticket form.

= What does Placeholder stand for in Advanced Features Simple Tickets > Settings? =
same as Label but this is the text displayed in the input field next to the Label if the field is empty. It disappears if the user types something in it.

= What does Type stand for in Advanced Features Simple Tickets > Settings? =
Similar to label and placeholder but this determines what input type this field has. E.g. say you want the user to just input numbers, you would select number and the user would be limited to just using numbers.
Placeholder does not work for the Type: 'select'.

= What does Enabled stand for in Advanced Features Simple Tickets > Settings? =
Enabled specifies if this field is enabled or disabled. If it is set to Yes then this field will be displayed in new ticket form (if not hidden) and in ticket settings when viewing a ticket.
If it is set to No then it will not be displayed anywhere. Bare in mind that it can be switched back on later.

= What does Required stand for in Advanced Features Simple Tickets > Settings? =
If Required is set to Yes then when a user (outside of admin panel) tries to create a  ticket, they will get a little red star next to the required field. Furthermore this field will be validated so if it is empty, the user will get an error and will have to input something into this field if they want to create a ticket.
If Required is set to No the user can input data into it but they do not have to so if it is left out blank and click Create Ticket it will be created.

= What is the 'Hidden' in Advanced Features Simple Tickets > Settings? =
If Hidden is set to Yes then the user (outside of admin panel) will not see this field altho it might be required, they will not see it and cannot input data into it. When the user creates a ticket then the admin set this field to whatever he or she wants through the admin panel when editing  their ticket.
However, if you are creating a ticket through the admin panel then you will see these hidden fields as you are the admin so you see everything.
If Hidden is set to No then the user (outside of admin panel) will see this field and if it is required they need to fill it in but if it is disabled they won't see it. Neither will you unless you switch it back on.

= What does Display in Ticket List stand for in Advanced Features Simple Tickets > Settings? =
If Display in Ticket List is set to Yes then when you view the Ticket List this field will be in one of the headers and you can sort all your tickets with this field if you click on it in the header (blue). If this field is Disabled then this won't have any affect.
If Display in Ticket List is set to No then this field won't be displayed in the Ticket List.

= What does Select Options (Only applies to Type: select) stand for in Advanced Features Simple Tickets > Settings? =
This stands for the select options the user can choose from. Of course if the Type of this field is set to 'select'.
Your select options have to be separated by commas (,) on order to split the select options.
This field does not work with any other Type so if you are trying to get select options working Type has to be set to select.

= I have changed one of my fields but it doesn't save =
It will save if you click on the Save button on the right. Don't forget that this Save button saves only your field that is on the line with the button.

= How do I edit the tickets content? =
You have to go into the ticket you want to edit, click Edit Ticket (it is by the Ticket Details on the right) and edit what you want click Update and done.

= How do I edit a comment? =
Same as to Edit Ticket but it says Edit Comment.

= How do I delete a ticket? =
Click Delete Ticket next to Edit Ticket | Move Ticket

= How do I delete a comment? =
Click Delete Comment next to Edit Comment | Move Comment

= Why does my Move Comment shows Simple Tickets logo? =
Because this feature is not available yet.

= How do I disable automatic sending emails if someone creates a ticket? =
Go into settings change 'Send E-mail to website administrator if someone creates a ticket?' to No and click Save

= How do I disable automatic sending emails if someone creates a comment? =
Go into settings change 'Send E-mail to website administrator if someone creates a comment in a ticket?' to No and click Save

= How do I disable automatic sending emails if someone changes ticket settings? =
Go into settings change 'Send E-mail to website administrator if someone updates a ticket settings?' to No and click Save

= How do I change Auto Save Backups off and how do they work? =
Go into Admin > General Settings and set Auto Save Backups to off.
This feature creates backup files of your database whenever there is a change (e.g. Updating or commenting on a ticket).
The backup files are called  e.g. <file_name>.BK00001 and the maximum number of backups per file is limited to 10,000 so do not
forget to delete the backups or archive them in order to maintain the Database size. 
in future updates we will automate this feature.

= How do I disable the output from scripts? =
Go into Admin > General Settings and set Display output from scripts to off.

= How do I switch Dashboard off? =
Go into Admin > General Settings and set Switch Globel Dashboard On or Off to off.

= How do I change Advanced Features on? =
Go into Admin > General Settings and set Advanced Features On/Off to on.

= When I change my General Settings the settings don't save =
Make sure after any change you do to click Save Settings button as otherwise your settings won't save.

= How do I delete a ticket through the Ticket List directly? =
If you wan't to delete a ticket directly through the Ticket list, you will see a column on the right saying 'Options' and it will contain
in line with the ticket an 'X' with red background. IF you click the 'X' the ticket will be deleted.

= How do I change the colour of the tickets? =
First you need advanced settings switched on in settings
then you need to go into Simple Tickets > Settings
if a field named 'Status' doesn't exist, rename one field to it and save
if the Type is not 'select', change it to select and add some options
save and then you should see Ticket List Colour '<Option>': your colour goes here
then save it and in Ticket List if a ticket has this field set to your desired option
then the colour will be set to the colour you have set in the Settings.

= Where do I edit the CSS  styling for the shortcodes? =
The CSS file responsible for the styling of [GBL_SMTCKS type=clear] is in Plugin Directory > Extension > simple-tickets > simple-tickets.css & shortcode.css

= How do I create a sticky ticket? =
First you need to create your ticket then you need to go to that ticket through the ticket list and change 'Sticky Ticket?' from 'No' to 'Yes'.

= How do I change the default Settings of the Control Options on Ticket List? =
You go into the Settings tab on the left menu and in 'Ticket List Control Settings' you choose the default settings you want to be used.

== Screenshots ==
1. Screenshot of Admin Panel > General Settings. Menus collapsed.
2. Screenshot of Admin Panel > General Settings. Menus expanded.
3. Screenshot of Simple Tickets > Ticket List. Three tickets with different 'Status'.
4. Screenshot of Simple Tickets > Settings. Some menus expanded & advanced features visible.
5. Screenshot of Simple Tickets > New Ticket. New ticket form.
6. Screenshot of Simple Tickets > Overall. Ticket settings showing that setting scale automatically to screen size.
7. Screenshot of WordPress > Pages > Shortcodes.
8. Screenshot of WordPress > Site Page with shortcode [GBL_SMTCKS].
9. Screenshot of WordPress > Site Page with shortcode [GBL_SMTCKS type=clear].
10. Screenshot of WordPress > Site Page with shortcode (any). Shows information about what field were missed etc.
11. Screenshot of Simple Tickets > Ticket List > Display Ticket (Clicked on one of the tickets). Showing the interface.
12. Screenshot of Simple Tickets > Ticket List > Display Ticket. Shows two comments in a ticket. Both expanded
13. Screenshot of Simple Tickets > Ticket List > Display Ticket. Shows two comments in a ticket. One is collapsed.
14. Screenshot of Simple Tickets > Ticket List > Display Ticket > Edit Comment/Edit Ticket.

== Changelog ==
= 0.1.7.8 =
* Maintenance release...
* Updated to new word press versions 5.2.3
* Backward compatibility with PHP 7.2 and previous versions 

= 0.1.6.6 =
* Ticket ID now generated from individual ticket files instead of the ticket list
* When creating a new ticket, ticket list is now opened only from current month instead of the last month
* Implemented built-in backup in Simple Tickets so the Database is backed up on every update if specified in the Admin
* A bug was tracked down and rectified due to file validation

= 0.1.6.5 =
* Ticket Detail/Comment(s) words splitting fixed; now a word will stay together instead of breaking for next line
* Bug Fix: Where ticket detail lines disappeared when creating a ticket
* Bug Fix: Last select option wasn't showing on the ticket settings when added through settings
* Sticky Tickets have different background and bottom border compared to other tickets
* New Setting Menu where you set default Ticket List Controls.
* Bug Fix: Now if a ticket exists in the ticket list but the ticket file doesn't exist the file will be re-created instead of it being deleted (Disappearing tickets bug fixed)
* New Feature: Now you can control your ticket list through the Control options at the top of your ticket list. You can set the list to be ascending/descending, sort the list by ticket id/date modified and you can choose with tickets to display if you have the 'Status' select option in your settings.
* New Feature: Now Tickets can be set as sticky (i.e. stay at the top of the list regardless of the Control Panel) through editting a ticket and changing the ticket setting 'Sticky Ticket?' to 'Yes' or 'No'
* New Feature: Listing all Tickets on the Front End through shortcode [GBL_SMTCKS_LIST], use [GBL_SMTCKS_LIST type=clear] for our CSS styling

= 0.1.6.4 =
* Bug Fix: Creating/Editing/Commenting/Deleting tickets, now files are locked so processes cannot interrupt each other if there is too many requests (Now tickets save correctly and don't overwrite each other).
* Bug Fix: Navigating to Next/Previous Tickets through a ticket. E.g. Ticket with IDs 1,2,4,5 exist and you would not be able to go from 2 to 4 directly but now you can
* Improved: Interface of 'Settings'
* Improved: Interface of 'New Ticket'
* Improved: Interface of 'Ticket List'
* Improved: Interface of 'Ticket List' > 'Display Ticket'
* Improved: Interface of 'New Ticket' on shortcode [GBL_SMTCKS]
* Improved: Load time of 'Settings' by Combined all forms to one
* Improved: Some functions within the plugin for performance and and stability
* Improved: Load time of 'Ticket List' > 'Display Ticket' by using only one form
* Features: Collapsing menues in 'Settings'
* Features: Deleting tickets directly from 'Ticket List'. Button on the right under Options
* Features: Adjusting colours of Status in 'Ticket List'. These settings can be accessed through 'Settings' > 'Status'
* Features: New feature in 'Ticket List'; now if there is more than 10 tickets, the header is also displayed at the botton of  the list

= 0.1.6.3 =
* Initial release.

== Upgrade Notice ==
= 0.1.6.6 =
Critical Update: A bug was found and rectified - (Lukasz C) Backup system is operating with Simple Tickets!

= 0.1.6.5 =
Some major fixes to do with ticket creation, modification and deletion. New Features like listing tickets on front end GUI and making tickets sticky.

= 0.1.6.4 =
This version includes a lot of stability improvements, performance improvements (load time of pages) and appearance adjustments so it is easier to follow. Forthermore, it has new features added.
