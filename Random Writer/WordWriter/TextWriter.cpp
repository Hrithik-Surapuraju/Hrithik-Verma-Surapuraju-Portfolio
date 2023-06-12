// Copyright 2022 Xxxxx
#include <ctime>
#include <iostream>
#include <fstream>
#include "WordWriter.h"

int main(int argc, char *argv[]) {
    if (argc != 3) {
        std::cout << "Usage: TextWriter <keyLen> <outputLen> < <inputFile>"
                  << std::endl;
        exit(0);
    }
    int keyLen = atoi(argv[1]);
    int outLen = atoi(argv[2]);
    std::string fileBuffer, linebuf;
    while (getline(std::cin, linebuf)) fileBuffer += (linebuf + "\n");

    WordWriter wordWriter(fileBuffer, keyLen);

    std::cout << wordWriter << std::endl;

    std::string k_gram = wordWriter.getWord();
    std::string output = wordWriter.generate(k_gram, outLen);

    std::cout << "OUTPUT:" << std::endl;
    std::cout << output << std::endl;
}
