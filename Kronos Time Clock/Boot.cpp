// Copyright 2022 Hrithik Verma Surapuraju
#include <unordered_map>
#include <algorithm>
#include <boost/date_time/posix_time/posix_time.hpp>
#include "Boot.h"
#include "Service.h"

Boot::Boot(std::string filename, int startLine, std::string dt,
           std::string startTime) {
    _filename = filename;
    _startLine = startLine;
    _date = dt;
    _startTime = startTime;
}

Boot::~Boot() {
}

void Boot::addService(Service& svc) {
    _services[svc.getName()] = svc;
}

void Boot::addService(std::unordered_map<std::string, Service>& m) {
    _services = m;
}

std::unordered_map<std::string, Service> Boot::getService() {
    return _services;
}

void Boot::completed(int completedLine, std::string completedTime) {
    _completedLine = completedLine;
    _completedTime = completedTime;
    // If completedLine equal 0 (incomplete) then we reset the services
    // completed line to zero
    if (completedLine == 0) {
        std::unordered_map<std::string, Service>::iterator itr =
                 _services.begin();
        for (itr = _services.begin(); itr != _services.end(); itr++) {
            (itr->second).completed(0, 0);
        }
    }
}

std::string Boot::getFilename() {
    return _filename;
}

std::string Boot::getDate() {
    return _date;
}

std::string Boot::getStartTime() {
    return _startTime;
}

std::string Boot::getCompletedTime() {
    return _completedTime;
}

int Boot::getStartLine() {
    return _startLine;
}

int Boot::getCompletedLine() {
    return _completedLine;
}

// svcName is Service Name array, taken from the first successfull boot
// session, and then used as reference for the next boot process
// For incomplete boot process, we take service name from this array.
void Boot::setSvcName(std::vector<std::string> svc) {
    _svcName = svc;
}

std::vector<std::string> Boot::getSvcName() {
    return _svcName;
}

// Output stream overload
std::ostream& operator <<(std::ostream& os, Boot& b) {
    os << "=== Device boot ===\n";
    os << b.getStartLine() << "(" << b.getFilename() << ") "
               << b.getDate() << " " << b.getStartTime()
               << " Boot Start\n";
    int cl = b.getCompletedLine();
    if (cl) {
        os << cl << "(" << b.getFilename() << ") "
               << b.getDate() << " " << b.getCompletedTime().substr(0, 8)
               << " Boot Completed\n";
        std::string t1 = b.getDate() + " " + b.getStartTime();
        std::string t2 = b.getDate() + " " + b.getCompletedTime();
        boost::posix_time::time_duration td =
              boost::posix_time::time_from_string(t2) -
              boost::posix_time::time_from_string(t1);
        os << "\tBoot Time: " << td.total_milliseconds() << " ms\n\n";
    } else {
        os << "**** Incomplete Boot ****\n\n";
    }

    os << "Services\n";
    std::unordered_map<std::string, Service> svc = b.getService();
    std::vector<std::string> svcName = b.getSvcName();

    for (int i = 0; i < svcName.size(); i++)
        os << svc[svcName[i]];

    if (cl == 0) {
        os << "\n\t*** Services not successfully started: ";
        int column = 48;
        for (int i = 0; i < svcName.size(); i++) {
            if (column + svcName[i].size() > 79) {
                os << "\n";
                column = 1;
            }
            os << svcName[i];
            if (i < svcName.size()-1) os << ", ";
            column += svcName[i].size() + 2;
        }
        os << "\n";
    }

    return os;
}

