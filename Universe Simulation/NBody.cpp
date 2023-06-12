#include <iostream>
#include <SFML/Graphics.hpp>
#include <SFML/Audio.hpp>
#include <fstream>
#include <string>
#include <vector>
#include <fstream>
#include <math.h>

void setOriginAndReadjust(sf::Transformable &object, const sf::Vector2f &newOrigin)
{
        auto offset = newOrigin - object.getOrigin();
        object.setOrigin(newOrigin);
        object.move(offset);
}

int main()
{
    
    sf::RenderWindow window(sf::VideoMode(1000, 1000), "The Solar System!");

    sf::Texture tbackground;
    sf::Texture tsun;
    sf::Texture tmercury;
    sf::Texture tvenus;
    sf::Texture tearth;
    sf::Texture tmars;
    sf::Texture tDeathStar;
    sf::Texture tStarDestroyer;
    sf::Texture tRepublicCruiser;

    sf::Sprite background;
    sf::Sprite sun;
    sf::Sprite mercury;
    sf::Sprite venus;
    sf::Sprite earth;
    sf::Sprite mars; 
    sf::Sprite deathstar;
    sf::Sprite DeathStar;
    sf::Sprite StarDestroyer;
    sf::Sprite RepublicCruiser;

    tsun.loadFromFile("sun.gif");
    tmercury.loadFromFile("mercury.gif");
    tvenus.loadFromFile("venus.gif");
    tearth.loadFromFile("earth.gif");
    tmars.loadFromFile("mars.gif");

    

    sun.setTexture(tsun);
    mercury.setTexture(tmercury);
    venus.setTexture(tvenus);
    earth.setTexture(tearth);
    mars.setTexture(tmars);

    
    sun.setPosition(500,500);
    mercury.setPosition(415,430);
    venus.setPosition(325,325);
    earth.setPosition(200,200);
    mars.setPosition(50,50);

    
    

    tbackground.loadFromFile("starfield.jpg");
    background.setTexture(tbackground);
    tbackground.setRepeated(true);
    background.setTextureRect(sf::IntRect(0,0,1000,1000));

    setOriginAndReadjust(mercury, {100,100});
    setOriginAndReadjust(venus, {190,190});
    setOriginAndReadjust(earth, {290,290});
    setOriginAndReadjust(mars, {380,380});

    sf::SoundBuffer buffer;

    if(!buffer.loadFromFile("2001.wav"))
    {
        std::cout << "ERROR" << std::endl;
    }

    sf::Sound sound;

    sound.setBuffer(buffer);

    sound.play();

    while (window.isOpen())
    {
        sf::Event event;
        while (window.pollEvent(event))
        {
            if (event.type == sf::Event::Closed)
            window.close();
        }

        mercury.rotate(-.2f);
        venus.rotate(-.1f);
        earth.rotate(-.05f);
        mars.rotate(-.035);


        window.clear();
        window.draw(background);
        window.draw(sun);
        window.draw(mercury);
        window.draw(venus);
        window.draw(earth);
        window.draw(mars);
        window.draw(deathstar);
        window.draw(RepublicCruiser);
        window.draw(StarDestroyer);
        window.display();       
    }

    return 0;
}