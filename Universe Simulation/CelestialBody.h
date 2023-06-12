#ifndef CELESTIAL_BODY
#define CELESTIAL_BODY
 
#include <iostream>
#include <fstream>
#include <SFML/Graphics.hpp>
#include <string>

class CelestialBody : sf::Drawable
{
    public:
        CelestialBody(double cxpos, double cypos, double cxvel, double cyvel, double cmass, std::string cfilename);
    private:
        double xpos;
        double ypos;
        double xvel;
        double yvel;
        double mass;
        std::string filename;
        sf::Image image;
        sf::Texture texture;
        mutable sf::Sprite sprite;
        void draw(sf::RenderTarget &target, sf::RenderStates states)const;
};

#endif