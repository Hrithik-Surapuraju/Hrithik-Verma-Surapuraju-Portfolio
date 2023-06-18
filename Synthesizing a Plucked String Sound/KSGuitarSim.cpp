// Copyright 2022 Hrithik Verma Surapuraju
#include <unistd.h>
#include <cmath>
#include <iostream>
#include <string>
#include "StringSound.h"
#include <SFML/Window.hpp>
#include <SFML/Audio.hpp>
#include <SFML/Graphics.hpp>

int main() {
    sf::Window window(sf::VideoMode(800, 600), "KSGuitarSim");
    std::string keys = "q2we4r5ty7u8i9op-[=zxdcfvgbnjmk,.;/' ";

    std::vector<std::vector<sf::Int16>> raw(37);
    std::vector<sf::SoundBuffer> buffer(37);
    std::vector<sf::Sound> sound(37);

    int rpt = 0;
    while (window.isOpen()) {
        sf::Event event;
        while (window.pollEvent(event)) {
            if (event.type == sf::Event::Closed) {
                window.close();
            }
            if (event.type == sf::Event::TextEntered) {
                // Get the index of the key entered
                int idx = keys.find(static_cast<char>(event.text.unicode));
                if (idx != std::string::npos) {
                    // Calculate frequency based on idx
                    double freq = 440 * pow(2, (idx - 24.0)/12.0);
                    // Create new StringSound
                    StringSound *ss = new StringSound(freq);
                    // And then pluck() it
                    ss->pluck();
                    // Clear the raw buffer
                    raw[idx].clear();

                    // Loop to fill the raw buffer
                    for (int i =0; i < 60000; i++) {
                        // Simulate sound at one particular time
                        ss->tic();
                        // Save the result to raw buffer
                        raw[idx].push_back(ss->sample());
                    }
                    // Assign raw buffer to SoundBuffer
                    buffer[idx].loadFromSamples(&raw[idx][0], raw[idx].size(),
                                                2, 44100);
                    // Assign SoundBuffer to Sound
                    sound[idx].setBuffer(buffer[idx]);
                    // Play it
                    sound[idx].play();
                    // Delete StringSound object
                    delete ss;
                }
            }
        }
    }
    return 0;
}

