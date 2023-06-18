// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream>
#include <fstream>
#include <SFML/Graphics.hpp>
#include "CelestialBody.h"

CelestialBody::CelestialBody(double cxpos, double cypos, double cxvel,
double cyvel, double cmass, std::string cfilename) {
  xpos = cxpos;
  ypos = cypos;
  xvel = cxvel;
  yvel = cyvel;
  mass = cmass;

  if (!image.loadFromFile(cfilename)) {
  exit(1);
  }

  texture.loadFromImage(image);

  sprite.setTexture(texture);
}

void CelestialBody::draw(sf::RenderTarget &target,
sf::RenderStates states)const {
  this->sprite.setPosition(xpos, ypos);
  target.draw(this->sprite, states);
}
