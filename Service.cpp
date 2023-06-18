// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream>
#include "Service.h"

Service::Service() {
}

Service::Service(std::string name, std::string logfile, int start):
    _name(name), _logfile(logfile), _startLine(start) {
}

Service::~Service() {
}

void Service::completed(int end, int elapsed) {
    _completedLine = end;
    _elapsedTime = elapsed;
}

std::string Service::getFilename() {
    return _logfile;
}

std::string Service::getName() {
    return _name;
}

int Service::getStart() {
    return _startLine;
}

int Service::getCompleted() {
    return _completedLine;
}

int Service::getElapsed() {
    return _elapsedTime;
}

std::ostream& operator <<(std::ostream& os, Service& S) {
    os << "\t" << S.getName() << "\n";
    if (S.getCompleted() == 0) {
        os << "\t\t Started: Not started(" << S.getFilename() << ")\n";
        os << "\t\t Completed: Not completed(" << S.getFilename() << ")\n";
        os << "\t\t Elapsed Time:" << std::endl;
    } else {
        os << "\t\t Started: " << S.getStart() << "(" <<
              S.getFilename() << ")\n";
        os << "\t\t Completed: " << S.getCompleted() << "(" <<
              S.getFilename() << ")\n";
        os << "\t\t Elapsed Time: " << S.getElapsed() << " ms\n";
    }
    return os;
}

