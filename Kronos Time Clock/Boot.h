// Copyright 2022 Hrithik Verma Surapuraju
#ifndef boot // NOLINT
#define boot // NOLINT
#include <iostream>
#include <string>
#include <vector>
#include <unordered_map>
#include "Service.h"

class Boot {
 public:
    Boot(std::string filename, int startLine, std::string dt, std::string tm);
    ~Boot();
    void addService(Service& svcName);
    void addService(std::unordered_map<std::string, Service>& svc);
    std::unordered_map<std::string, Service> getService();
    void completed(int completedLine, std::string completedTime);
    std::string getFilename();
    std::string getDate();
    std::string getStartTime();
    std::string getCompletedTime();
    int getStartLine();
    int getCompletedLine();
    int getElapsed();
    void setSvcName(std::vector<std::string> sn);
    std::vector<std::string> getSvcName();

 private:
    std::unordered_map<std::string, Service> _services;
    std::vector<std::string> _svcName;
    std::string _filename;
    std::string _date;
    std::string _startTime;
    std::string _completedTime;
    int _startLine;
    int _completedLine;
};

std::ostream& operator <<(std::ostream& os, Boot& b);

#endif  // NOLINT

