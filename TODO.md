BugtrackerBundle
================

Todo List
---------

### High priority
- Debug : correct author id at ticket creation
- Debug : prevent user password reset when empty on user edit
- Create COMMENT entity to enable ticket discussions (add email notification)
- Add "Close" ticket feature, archived but not visible (reversible)
- Add Ticket many user assignement
- Add WYSIWYG for texareas
- Send mails after ticket creation / modification / deletion to author & allocated user
- Enable email notification subscription for ticket/project

### Medium priority

- Add screenshot(s) to tickets
- Add upload files interface for tickets (check file managment methods)
- Add delete confirmation for any deletion
- Add role in user list

### Low priority

- User : user FOSUserBundle for user management
-- Check email unicity
-- Add sign up possibility with account validation
-- Add "stay login" feature
- Add a recap in dashboard : Tickets in progress (3) Tickets to do (4) ...
- Handle delete errors (notification) on user/company/project attempt to remove