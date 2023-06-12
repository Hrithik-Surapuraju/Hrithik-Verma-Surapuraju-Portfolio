/**********************************************************************

 *  ps3-readme 

 *  Recursive Graphics (Triangle Fractal)                       

 **********************************************************************/



Your name: Hrithik Verma Surapuraju



Hours to complete assignment: 8



/**********************************************************************

 *  Briefly discuss the assignment itself and what you accomplished.

 **********************************************************************/





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



/**********************************************************************

 *  Discuss one or more key algorithms, data structures, or 

 *  OO designs that were central to the assignment.

 **********************************************************************/



Triangle Fractal program is a good example to practicing several functions, such as:



- How to draw equalateral triangle, from the given point coordinate. I have to calculate the other points coordinate with math calculation,

 using sin() and cos() function.

In my implementation, triangle constructor have three inputs: base length, center x coordinate, and center y coordinate. From those three 

value we calculate three points of triangle.



- How to solve the problem using recursive process. The most important thing in recursive process is how to define the condition where the program 

stop to calling the next level process. Here it has depth level that have some value in the initial level, and decrement it calls the next level. 

When the depth value become zero then the recursive function just return to the caller. 



- Define triangle class, having constructor with three inputs parameter, base length, x coordinat of center, and y coordinate of center.

From input parameter we calculate three points of triangle, that will be keep in private variable (x1, y1, x2, y2, x3, y3).

With this class we can draw any equilateral triangle with any base length size, at any position.





/**********************************************************************

 *  Briefly explain the workings of the features you implemented.

 *  Include code excerpts.

 **********************************************************************/





It has recursive function called fractal() with 3 input parameters, first is renderedWindow as a target of object drawing, second is triangle object,

and the third one is depth level.

Basically, when the function is called, it will draw triangle object and it's child triangle to the rendered window. 

Child triangle will be drawn by calling fractal function with lower depth level.



void fractal(sf::RenderWindow& w, Triangle tr, int depth) {

    if (depth == 0) return;

    int x1, y1, x2, y2, x3, y3;

    int x, y;



    tr.get_points(&x1, &y1, &x2, &y2, &x3, &y3);

    int len = tr.get_baselen()/2;



    tr.set_color(depth % 5);

    w.draw(tr);



until this point, it draw the main triangle with color index set to (depth % 5).

Then it will draw it's child by calling fractal function recursively.



    // 1st child

    x = x1;

    y = y1 - 2 * sqrt(pow(len, 2)/12);

    Triangle tr1(len, x, y);

    fractal(w, tr1, depth-1);



    // 2nd child

    x = x2 + len / 2;

    y = y2 + sqrt(pow(len, 2)/12);

    Triangle tr2(len, x, y);

    fractal(w, tr2, depth-1);



    // 3rd child

    x = x3 - len / 2;

    y = y3 + sqrt(pow(len, 2)/12);

    Triangle tr3(len, x, y);

    fractal(w, tr3, depth-1);

}







Coloring is done based on depth level because we prepare 5 colors to be used, so we use formula (depth % 5) to decide which color to be used.

We can change number of colors to any number to get more colorful triangle.





/**********************************************************************

 *  Briefly explain what you learned in the assignment.

 **********************************************************************/



Recursive function make the complex iteration process more simple, as we just write down one level process, called it repeatedly for the next level,

but the important thing is to define the condition where we stop calling the function and just return to the caller.



/**********************************************************************

 *  List whatever help (if any) you received from the instructor,

 *  classmates, or anyone else.

 **********************************************************************/



none

/**********************************************************************

 *  Describe any serious problems you encountered.  

 *  If you didn't complete any part of any assignment, 

 *  the things that you didn't do, or didn't get working.                  

 **********************************************************************/



none



/**********************************************************************

 *  List any other comments here.                                     

 **********************************************************************/

fractal is the exe

