// Copyright 2022 Xxxxx
#include <ctime>
#include <iostream>
#include <fstream>
#include "RandWriter.h"

//unsigned mseed;

int main(int argc, char *argv[]) {
    if (argc != 3) {
        std::cout << "Usage: TextWriter <keyLen> <outputLen> < <inputFile>"
                  << std::endl;
        exit(0);
    }
    int keyLen = atoi(argv[1]);
    int outLen = atoi(argv[2]);
    //mseed = unsigned(time(0));
    std::string fileBuffer, linebuf;
    while (getline(std::cin, linebuf)) fileBuffer += (linebuf + "\n");

    RandWriter randWriter(fileBuffer, keyLen);

    std::cout << randWriter << std::endl;

    std::string k_gram = randWriter.getKgram();
    std::string output = randWriter.generate(k_gram, outLen);

    std::cout << "OUTPUT:" << std::endl;
    std::cout << output << std::endl;
}
