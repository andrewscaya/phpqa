# Plotting

I like this tool
However it's not "mine" and after the reaction from my first PRs and Issues, no I'm not fighting someone over changes all the time
I can tell how well a person will work with changes to their project after that first interaction and it is simply not worth my time

So, fork it is

## Initial Plans

First, I'd really like to rename it - there are so many things called "phpqa" that it's crazy confusing

phpqa-reporter - that I like (also muy descriptive)

goals:
* fix the naming and branding so it's less ambiguous
* make it work cross platform
* set up windows automated testing
* allow for pluggable outputs
* allow for pluggable tools
* allow for pluggable configuration
* fix issues with verbosity
* provide more control over partial tool runs

Todo list

- [x] Make it work on windows - might have broken it on nix but for now don't care, it runs and works :)
- [ ] Add phpunit and code coverage output as a tool
- [ ] Fix the command line (sigh) and configuration ( we'll keep yml for now, but we should allow any pluggable format - they all get parsed into php arrays anyway)
- [ ] Make tool system pluggable
- [ ] Make output system pluggable
- [ ] Fix our tool verbosity issues (robo is spewing and most tools have controls that can be used)
- [ ] Allow for tool logging (turn up verbosity + turn up logging should still be quiet)
- [ ] allow for more commands - right now we have "clean and run all tools and render all reports" - should have all, clean, run/update? argue about naming later, generate, etc
- [ ] allow for settable ansi (I'm on anniversary edition dangit, I want my pretty colors)
- [ ] better overall reporting - this is a loftier and somewhat ambiguous goal

If I get really ambitious I might wiggle about with the deps

Also I've said this before and I'll say it again - TRAITS ARE FOR BEHAVIOR - not for "putting together" classes like legos </endrant>
