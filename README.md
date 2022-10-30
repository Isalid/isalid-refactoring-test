# Refactoring Kata Test

## Introduction

Let's say we are a company specialized in merchandise transport in different countries, and we have some message templates we want to send
in different languages. To do that, we've developed `TemplateManager` whose job is to replace
placeholders in texts by travel related information.

`TemplateManager` is a class that's been around for years and nobody really knows who coded
it or how it really works. Nonetheless, as the business changes frequently, this class has
already been modified many times, making it harder to understand at each step.

Today, once again, the PO wants to add some new stuff to it and add the management for a new
placeholder. But this class is already complex enough and just adding a new behaviour to it
won't work this time.

Your mission, should you decide to accept it, is to **refactor `TemplateManager` to make it
understandable by the next developer** and easy to change afterwards. Now is the time for you to
show your exceptional skills and make this implementation better, extensible, and ready for future
features.

Sadly for you, the public method `TemplateManager::getTemplateComputed` is called everywhere, 
and **you can't change its signature**. But that's the only one you can't modify (unless explicitly
forbidden in a code comment), **every other class is ready for your changes**.

This exercise **was made to not last longer than 1 hour** but we know that this can be too short to do it all and
you might take longer if you want. Stop when you feel you've done something you feel comfortable sharing with us.

You can run the example file to see the method in action.

## Rules
There are some rules to follow:
 - You must commit regularly
 - You must not modify code when comments explicitly forbid it

## Deliverables
What do we expect from you:
 - the link of the git repository
 - several commits, with an explicit message each time
 - a file / message / email explaining your process and principles you've followed

**Good luck!**

## My job

### En français ça ira plus vite :

- ajout de l'autoloading avec les namespace
- passage en php 7.4 pour plus de typage
- typage fort 
- ajout de getter et setter
- refacto de TemplateManager

### TODO :
- extraire les methodes computeSummary computeDestination, computeUser, computeSummaryHTML dans des classes avec une interface commune. Les injecter en dépendance du TemplateManager pour n'avoir besoin que de faire un compute sur chacune d'entre elles.
- mettre les quotes `[quote:summary]` en CONSTANTE
- faire les tests 

### Après 1h 
- j'ai dépassé le temps, j'ai mis un test, mais il en faudrait d'autres qui testent les fails, et testent le user et le html dans le message
- j'ai relu la consigne pour voir si je ne m'étais pas trompé. J'ai du reverte quelques modifications sur TemplateManager::getTemplateComputed