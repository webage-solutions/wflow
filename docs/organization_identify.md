# Organization identify flow

Identifying the organization is a important feature of WFlow.

The system was designed to be able to support multi-tenancy and white-labelling,
so identifying the organization is extremely important to give the customer a while label feel.

To achieve that, we created the organization concept. Organizations are entities that represents a layer of settings
 in the system. When the user access the system, he'll always accessing an organization (application users are always
  part of at least one organization). It's possible to be part of more than one organization, but it shouldn't be usual.
  
An user always have a `current_organization` defined (a user can only access one organization at a time). Is up to
 the UI to keep multiple sessions (for multiple users or multiple organizations for the same user on the same browser).
  
When a user is logged, is easy to detect which organizations he is a member, and to get the current one (we have a
 key on the user entity that defines that).
 
When there is no user logged (i.e. when accessing the login screen), we need to identify the organization that is been
accessed. It's up to the UI to send a `X-Wflow-Organization` containing the id of the organization been accessed.

The organization detection is done inside the RequestState component, on the middleware.

UI must detect this based on the domain, or organization key sent on the request.

TODO - Defined how UI do that!



 