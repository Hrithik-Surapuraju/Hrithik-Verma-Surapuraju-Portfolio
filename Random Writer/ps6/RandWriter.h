// Copyright 2022 Xxxxx
#ifndef _HOME_DJOKO_RANDWRITER_RANDWRITER_H_
#define _HOME_DJOKO_RANDWRITER_RANDWRITER_H_
#include <iostream>
#include <string>
#include <algorithm>
#include <vector>
#include <map>

class RandWriter {
 public:
    RandWriter(std::string text, int k);
    ~RandWriter();
    int order_k();
    int freq(std::string k_gram);
    int freq(std::string k_gram, char c);
    char k_Rand(std::string k_gram);
    std::string generate(std::string k_gram, int L);
    std::string getAlphabet();
    void setKgram();
    std::string getKgram();

 private:
    std::string _alphabet;
    std::string _k_gram;
    std::map<std::string, std::vector<int> > _keyfreq;
    int _k;
};

std::ostream& operator <<(std::ostream& os, RandWriter& R);

#endif  // _HOME_DJOKO_RANDWRITER_RANDWRITER_H_

