BugtrackerBundle
================

Todo List
---------

### High priority
- Add Ticket state assignement possible for many users
- Add email notification for ticket state added with direct link (with anchor)

- Add ticket text content and leaver states only for comments and dicsussion (and Add WYSIWYG for texareas) and Redesign ticket Edit page and list (add content and comments)
   ---- Hide project input and lock authorUser when not admin
   ---- Make Table header follow scroll
   ---- Put anchor links on redirect
   ---- DEBUG : redirect => refresh cache ORM or something like (DONT DO TI BUT ASK NICO)


- Add upload files interface for tickets (check file managment methods) and add remote document links (Like google drive or other)
- Add Ticket state files
- Allow user to edit their profiles

### Medium priority
- Add ticket state modification for author and admin (+ add field updatedAt to control) + ticket state deletion (!Id ticket current state)
- FOSUserBundle + signup with confirmation + "stay login" (https://knpuniversity.com/screencast/symfony2-ep2/remember-me#play)
- Manage page titles
- Add "go to #ticketId" functionnality
- Update bootstrap
- Define roles hierarchy

### Low priority

- Add a recap in dashboard : Tickets in progress (3) Tickets to do (4) ...
- Handle delete errors (notification) on user/company/project attempt to remove + Add delete confirmation for any deletion
- Add roles : SUPER_ADMIN (all projects, all abilities) and modify ADMIN (restricted to project)
- Add roles : MEMBER, CLIENT
- Debug : don't redirect on Dashboard at language change
- Add go to bottom front office feature (where is last comment)
- Add user references and skills
- Make functionnal tests
- Add design customisation by Company

### Major Evolutions
- Add many project management types
---- Comprehensive : each project member can create, allocate and close tickets
---- Restricted : Only project master can create, allocate and close ticket
- Add many project interfaces (by companies)
---- Straight : Everyone named by their names
---- Friendly : Usernames 


### CURRENT WORK
- On delete ticketState, contrôle currentTicketStateId From ticket
- aDD REFUSED TICKET STATE
- HISTORY ONLY SHOW CHANGES AS COMMENT
- AUTO ASSIGN NEW TICKET FROM CLIENT TO PROJET MASTER (NEED ROLES MANAGEMENT AND FOS USER FIRST)
	ROLES : CLIENT > MEMBER > MASTER > ADMIN > SUPER ADMIN
	CLIENT : restrained to a a project (some tickets )