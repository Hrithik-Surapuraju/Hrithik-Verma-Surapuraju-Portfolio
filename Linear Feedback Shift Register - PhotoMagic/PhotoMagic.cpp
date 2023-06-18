// Copyright [2022] <Hrithik Verma Surapuraju>
#include <string>
#include <ctime>
#include <bitset>
#include "FibLFSR.h"
#include <SFML/System.hpp>
#include <SFML/Window.hpp>
#include <SFML/Graphics.hpp>


void transform(sf::Image& image, FibLFSR* seed) { // NOLINT
    sf::Color p;
    sf::Vector2u t = image.getSize();
    int xi = t.x;
    int yi = t.y;

    for (int x = 0; x < xi; x++) {
      for (int y = 0; y < yi; y++) {
      p = image.getPixel(x, y);
      p.r = p.r ^ seed->generate(15);
      p.g = p.g ^ seed->generate(15);
      p.b = p.b ^ seed->generate(15);
      image.setPixel(x, y, p);
      }
    }
}

int main(int argc, char* argv[]) {
    std::string seed;
    std::string input;
    std::string output;
    std::string seed_true;
    std::cin >> input >> output >> seed;

    seed_true = std::bitset<1>(seed[0]).to_string();
    for (int i = 1; i < seed.size(); i++)
    seed_true += std::bitset<1>(seed[i]).to_string();

    FibLFSR s(seed_true);

    sf::Image image1;
    if (!image1.loadFromFile(input))
    return -1;

    sf::Texture texture1;
    texture1.loadFromImage(image1);

    sf::Sprite sprite1;
    sprite1.setTexture(texture1);


    sf::Image image2;
    if (!image1.saveToFile(output))
    return -1;

    if (!image2.loadFromFile(output))
    return -1;

    transform(image2, &s);

    if (!image2.saveToFile(output))
    return -1;
    sf::Texture texture2;
    texture2.loadFromImage(image2);

    sf::Sprite sprite2;
    sprite2.setTexture(texture2);

    sf::Vector2u t = image1.getSize();

    int xi = t.x;
    int yi = t.y;

    sf::RenderWindow window1(sf::VideoMode(xi, yi), "Source");
    sf::RenderWindow window2(sf::VideoMode(xi, yi), "Output");

    while (window1.isOpen() && window2.isOpen()) {
    sf::Event event;
    while (window1.pollEvent(event)) {
    if (event.type == sf::Event::Closed)
    window1.close();
    }
    while (window2.pollEvent(event)) {
        if (event.type == sf::Event::Closed)
        window2.close();
    }
        window1.clear();
        window1.draw(sprite1);
        window1.display();
        window2.clear();
        window2.draw(sprite2);
        window2.display();
    }
    if (!image2.saveToFile(output)) {
    return -1;
    }
    return 0;
}
