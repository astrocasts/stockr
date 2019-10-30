![](https://d.pr/i/2vExfN+)

# Event Sourcing with Laravel and EventSauce

Let's build a real-world Event Sourced application using Laravel and EventSauce!



### Goals

* Build an inventory managment system named Stockr
* Use Laravel for the base application
* Use EventSauce ([EventSauce.io](https://EventSauce.io)) for the Event Store
* Use Eloquent ORM for parts of the Read Model
* Build an Command Bus around Tactician
* Build a standalone Projections package



### Tasks

* [x] Create the Laravel project
* [x] Bring in [EventSauce](https://eventsauce.io)
* [x] Write our own Message Repository implementation (based on [eventsauce/doctrine-message-repository](https://github.com/EventSaucePHP/DoctrineMessageRepository))
  * [x] [`DB::getDoctrineConnection()`](https://github.com/astrocasts/stockr/pull/1) (thanks @phcostabh!)
  * [ ] [Laravel and Doctrine DBAL Transactions do not play nicely with each other...](https://gist.github.com/simensen/3bb6aa09c6250946a816147c839467c9)
  * [x] Remove Aggregate Root ID Type column
* [ ] Bring in [Tactician](https://tactician.thephpleague.com) (v2)
* [ ] Build a Command Bus



### Get Connected

- [Join Astrocasts chat on Discord](https://discord.gg/gAYN5RT)
- [Watch on Astrocasts](https://astrocasts.com/live-sessions/projects/event-sourcing-with-laravel-and-eventsauce)
- [Subscribe to /Astrocasts on YouTube](https://youtube.com/astrocasts)
- [Watch Astrocasts on Twitch](https://twitch.tv/beausimensen)
- [Follow @astrocasts on Twitter](https://twitter.com/astrocasts)





