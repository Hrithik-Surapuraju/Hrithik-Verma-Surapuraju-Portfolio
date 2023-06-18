// Copyright 2022 Hrithik Verma Surapuraju
#include <ctime>
#include <iostream>
#include <fstream>
#include "RandWriter.h"
//commnent above line 5 for extra credit
//Uncomment below line for extra credit 
//#include "WordWriter.h" 
//commnent lines 10 - 30 for extra credit
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

    RandWriter randWriter(fileBuffer, keyLen);

    std::cout << randWriter << std::endl;

    std::string k_gram = randWriter.getKgram();
    std::string output = randWriter.generate(k_gram, outLen);

    std::cout << "OUTPUT:" << std::endl;
    std::cout << output << std::endl;
}

//uncommnet lines 34 - 54 for extra credit
/*
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
*/