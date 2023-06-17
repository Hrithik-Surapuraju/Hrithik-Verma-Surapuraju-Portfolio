# Hrithik-Verma-Surapuraju-Portfolio
A portfolio of all my projects

C++ SFML Projects-
Dependencies:
- An Ubuntu linux VM
- SFML Library (https://www.sfml-dev.org/)

Left Bit Shift Register - 

The program first asks the user for the name of the source file(THIS FILE SHOULD EXIST), 
the name they want for the output file, and the seed (has to be alpanumeric string no spaces 
or special characters). It then takes the rgb value of each pixel of the image and does an XOR function 
with a generate(8) function to generate an encrypted or decrypted image depending 
on the context. The alphanumeric seed for encryption and decryption must be the same!

It can also take an alphanumeric string and convert to a bitset. It first takes the 0th element of the seed and makes a bitset
of a bit and set it as the string for true_seed, It then takes the reamining characters in the alphanumeric password into a for loop and converts them to a bit
and concatinate all of them to true seed and it would stop if the string size has been reached. True seed is then passed to FIBLFSR.
For Decrypting the same alphanumerc string should be passed case sensitive. It interesting because the bitset object is very versatle in making bit strings and alphanumerc
passwords give more strength to the passwords as it increases the combinations.

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

The program take k_gram length from input argument, and then start to parse input file and create keyfreq to keep the frequency of all k_gram and k+1_gram.
Once the k_gram frequency is ready, we take one k_gram randomly from keyfreq and use it as the initial k_gram, starting the output.
Then we start to take one character at the time randomly, the random should reflected the distributed frequency character for this k_gram.

To implement random writer program, I used a map and vector data structure as follows:
   keyfreq ---- map<string, vector<int>>

and used k_gram as the key of mapping. At the data side I have a vector of 129 elements, where from index 0 to 127 are used to keep frequency 
of char(idx) that following the k_gram, and index 128 (the last index) is used to keep the frequency of k_gram in the whole text

Kronos Time Clock - 

std::regex e_svcstart("Starting Service.(\\s*)(\\S*) (.*)");
-The above regex checks that a serivce is staring.
Here I try to find the input line, starting with "Starting Service." and then
followed by white space (\s*), and then followed by word (\S*), followed by
one space and any characters in the rest (.*)

std::regex e_start("(\\S*) (.*)log.c.166(.*)server started(.*)");
-The above regex checks to see if the following is present and boots up the device. 
Here I try to find the input line starting with a word (\S*) followed by log.c.166
followed by any character, and followed by "server started" followed by any characters.

std::regex e_compl("(\\S*) (.*)oejs.AbstractConnector:Started " \
                    "SelectChannelConnector(.*)");
-The above Regex checks the completion of the boot up sequence
Here I try to find the input line starting with word (\S*) followed by any character 
followed by oejs.AbstractConnector:Started followed by SelectChannelConnector followed by any character.
followed by any character, and followed by "server started" followed by any character.

std::regex e_svccompl("Service started successfully.(\\s*)(\\S*) " \
                        "(\\S*) (.)(\\S*) (.*)");
-The above regex checks that the service was successful in starting
Here I try to find the input line starting with "Service started successfully." then followed by a whitespace
followed by a word, followed by two words separated by a "." followed by any character.
