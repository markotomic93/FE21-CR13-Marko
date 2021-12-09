# Code Review 13
 
 120 Points Reached
 
For this CodeReview, the following criteria will be graded:

(20) Create a nice looking responsive theme. You can use Bootstrap or just HTML/CSS. (backenders exempt)

Implement an interface for the CRUD on Events:

(20) Event index page: all events should be listed here like in the image above (event name, event date and time). Feel free to use Bootstrap cards to display the events.

(20) Event view page (details page): when a user clicks on the event card/button, an event view page with all the data from that specific event should be displayed.

(15) Event edit page: on this page, it should be possible to edit the event data.

(15) Event add/create page: on this page, it should be possible to add a new event.

(10) Event delete option: a user should be able to delete an event from the database.

Please note that the file upload is not mandatory for this Code Review.

Bonus Points:

(20) Create filtering depending on the event type (hint: pass the information to the URL)

Hint: you could use the method findBy()

$repository = $this->getDoctrine()->getRepository(Event::class);

$events = $repository->findBy(['type' => 'music']);

This method takes an array as an argument and will return an array with all the results matching the search criteria.
