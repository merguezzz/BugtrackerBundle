BugtrackerBundle
================

Todo List
---------

### High priority
- Debug : prevent user password reset when empty on user edit
- Add email notification for ticket state added with direct link
- Add Ticket many user assignement
- Add WYSIWYG for texareas
- Enable email notification subscription for ticket/project

### Medium priority

- Add screenshot(s) to tickets
- Add upload files interface for tickets (check file managment methods)
- Add delete confirmation for any deletion
OK - Add role in user list
- Ability for role USER to modifiy his profile (or FOSuserBundle directly ?)

### Low priority

- User : user FOSUserBundle for user management
-- Check email unicity
-- Add sign up possibility with account validation
-- Add "stay login" feature
- Add a recap in dashboard : Tickets in progress (3) Tickets to do (4) ...
- Handle delete errors (notification) on user/company/project attempt to remove
- Add roles : SUPER_ADMIN (all projects, all abilities) and modify ADMIN (restricted to project)
- Add roles : MEMBER, CLIENT
- Debug : don't redirect on Dashboard at language change

### Major Evolutions
- Add many project management types
---- Comprehensive : each project member can create, allocate and close tickets
---- Restricted : Only project master can create, allocate and close ticket
- Add many project interfaces (by companies)
---- Straight : Everyone named by their names
---- Friendly : Usernames used