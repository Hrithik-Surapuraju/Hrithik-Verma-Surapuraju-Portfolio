// Copyright 2022 Hrithik Verma Surapuraju
#ifndef service // NOLINT
#define service // NOLINT

#include <iostream>
#include <string>

class Service {
 public:
    Service();
    Service(std::string name, std::string logfile, int start);
    ~Service();
    void completed(int end, int elapsed);
    std::string getFilename();
    std::string getName();
    int getStart();
    int getCompleted();
    int getElapsed();

 private:
    std::string _name;
    std::string _logfile;
    int _startLine;
    int _completedLine;
    int _elapsedTime;
};

std::ostream& operator <<(std::ostream& os, Service& S);

#endif  // NOLINT
