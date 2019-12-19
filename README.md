# The Event Bus library #

[![Build Status](https://travis-ci.org/kuai6/event-bus.svg?branch=master)](https://travis-ci.org/kuai6/event-bus)

This library provide abstract classes and interfaces to implement simple and powerfull tool to communicate bettween your services or aplications.


## Message ##

Message it is kind of DTO (Data Transfer Object), wich contains business data of your service or application that need to be sent to another service or application. 
Message have a headers, content and raw attributes.
 
 * Message::headers it is headers to tell your or target system what data message contains (the name of serializer data or  content type of this message, etc)
 * Message::raw it is attribue to store your own data
 * Message::content - content

## Drivers ##

Drivers - abstraction layer to handle communication between infrastructure and application layer. 
According to DriverInterface driver **MUST** implements methods **to push** message into transport and **to get** message from transport.
Also driver **MUST** implements method to **confirm** and  **reject** messages.
This library provides one specific driver - DriverChain.

* **DriverChain**
  It is simple driver to union your drivers into a collection. All configured drivers into chain will be fired consistently.
 

## Metadata Reader ##

Metadata reader - tool to read stored metadata of your messages or drivers. It may store configuration of your transport or message build schema.


## Logger ##

PSR Logger need to log all actions you need.

## Requirements ##

    "php": ">=7.1",
    "ramsey/uuid" : "~3.0.0",
    "psr/log": "~1.0.0"