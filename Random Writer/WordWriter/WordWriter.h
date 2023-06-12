// Copyright 2022 Xxxxx
#ifndef _HOME_DJOKO_RANDWRITER2_WORDWRITER_H_
#define _HOME_DJOKO_RANDWRITER2_WORDWRITER_H_

#include <iostream>
#include <string>
#include <algorithm>
#include <vector>
#include <map>

class WordWriter {
 public:
    WordWriter(std::string text, int k);
    ~WordWriter();
    int order_k();
    int freq(std::string word);
    int freq(std::string word1, std::string word2);
    std::string k_Rand(std::string word);
    std::string generate(std::string word, int L);
    void setWord();
    std::string getWord();

 private:
    std::string _word_gram;
    std::map<std::string, std::map<std::string, int> > _wordfreq;
    int _k;
};

std::ostream& operator <<(std::ostream& os, WordWriter& W);

#endif  // _HOME_DJOKO_RANDWRITER2_WORDWRITER_H_
