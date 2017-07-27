# Requirements

A rough requirements specification.


## Roles of users

Site needs an admin account. Everyone else doesn't log in, posting comments doesn't require an account.


## Entities

The focus is on photos. A photo can have a description and multiple comments. Multiple photos are grouped to a post. The photos don't have a title and publish date associated with them, only the post does.


## Functionalities

These are sort of like use cases.


### Accessible to Admin only:

* Upload a photo
  
  Preferably make it possible to upload multiple photos at once.

* Publish a post
  
  Should be possible to set a future publishing date and time. Unpublished posts should be visible to admin anyway, but visually distinct from published posts

* Delete comments

* Edit post

  This is mostly about title and photos contained (also order of photos in post), but might also include timestamp if possible

* Edit photo description

  Even on live photos


### Accessible to everyone

* Overview of all posts

* Post a comment on a photo

  Maybe link to gravatar. This would require users to leave their email though, but it can be an optional field.

* View comments on a photo

  Normal user shouldn't see email addresses of other users.



## Layout / Visuals