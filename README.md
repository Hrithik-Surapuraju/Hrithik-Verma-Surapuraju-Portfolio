# Hrithik-Verma-Surapuraju-Portfolio
A portfolio of all my projects

C++ SFML Projects-
Dependencies:
- An Ubuntu linux VM
- SFML Library (https://www.sfml-dev.org/)

Left Bit Shift Register - 

Universe Simulation - 

  The Program first extracts the relevent planet data from the planets.txt file for
  the sun, mercury, venus, earth and mars. Data included in this text file is the distance from the sun was well as velocity.
  The data is used by the celestialbody class to create and plot these planets out on the window using the sf::drawble class with the sun as the
  center point and mars as the end point. For Moving the planets, the universe class uses the velocity from the celestial body class and slightly increments it around the sun
  with the given emulated velocity giving the illusion of "rotation." The background is a texture of a star field stretched to fill in the window.

Fractal Triangle -

  To create this object, I have to define Triangle class which is derivated from sf::Drawable class, and fTree function performing recursion process.

  Triangle class:
  It have 3 input parameters, first is baselen the length of triangle edge, second is x coordinat of triangle's center, and the third is y coordinate 
  of triangle's center. In the construction function, it will calculate three points of the triangle.
  Then it will print line to connect between the three points. fTree will perform recursive process, it has three input parameters,
  RenderWindow, Triangle object, and recursion depth. For each recursion process it will print one main triangle and three child triangle. 
  The child triangle will be created by calling the same fTree function, with depth = depth - 1. If depth value equals zero, then fTree function just
  return to the caller. It looks like a tree with three childs in each level.
  In main function it calculates window size based on baselen input. And doing while loop to check the events.
  Coloring will be done based on depth level. It prepare 5 colors to be used, and use formula (depth % 5) to decide which color to be used.

DNA Sequence Alignment - 
  
  

Random Writer - 

Kronos Time Clock - 
