// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream> // NOLINT
#include <SFML/System.hpp> // NOLINT
#include <string> // NOLINT
#include <fstream> // NOLINT

class EDistance{
 public:
    EDistance(std::string a, std::string b);
    int penalty(char a, char b);
    int min(int a, int b, int c);
    int OptDistance();
    std::string Alignment();
 private:
    int x;
    int y;
};

int main() {
    sf::Clock clock;
    sf::Time t;
    int Edit_distance;
    std::string filename;
    std::cout << "Filename: ";
    std::cin >> filename;
    std::cout << "Edit distance = ";
    std::cin >> Edit_distance;
    std::ifstream file(filename);
    std::string string1;
    std::string string2;
    t = clock.getElapsedTime();
    if (file.is_open()) {
        getline(file, string1);
        getline(file, string2);
        file.close();
    } else { std::cout << "Unable to open file"; }

    EDistance objct(string1,string2);

    int i = 0;
    auto prnt = [](int i, std::string string1, std::string string2, EDistance objct) {
         while(string1[i] != '\0') {
        std::cout << string1[i] << " " << string2[i] << " " << objct.penalty(string1[i],string2[i]) << std::endl;
        i++; 
        }
    };
    
    prnt(i,string1,string2,objct);

    std::cout << "Execution time is " << t.asSeconds() << " seconds \n";
    return 0;
}

EDistance::EDistance(std::string a, std::string b) {
    int size_a = a.size();
    int size_b = b.size();
    x = size_a;
    y = size_b;
}

int EDistance::penalty(char a, char b) {
    
    if (a == b) {
        return 0;
    }
        return 1;
    
    if( a == ' ' || b == ' ')
    {
        return 2;
    }
}

int EDistance::min(int a, int b, int c) {
    int smallest = 99999;

    
    if (a < smallest)
        smallest = a;
    if (b < smallest)
        smallest = b;
    if (c < smallest)
        smallest = c;

    return smallest;
}

int EDistance::OptDistance() {
    char opt[x][y];
    int i = 0;
    int j = 0;
    opt[i][j] = min(opt[i+1][j+1] + 0/1, opt[i+1][j] + 2, opt[i][j+1] + 2);
    opt[i][j] = opt[i+1][j+1];
    opt[i][j] = opt[i+1][j+1] + 1;
    opt[i][j] = opt[i+1][j] + 2;
    opt[i][j] = opt[i][j+1] + 2;

    return opt[i][j];
}

std::string EDistance::Alignment() {
    OptDistance();
    return "";
}
