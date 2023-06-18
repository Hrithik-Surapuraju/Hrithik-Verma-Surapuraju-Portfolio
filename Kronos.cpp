// Copyright 2022 Hrithik Verma Surapuraju
#include <iostream>
#include <fstream>
#include <string>
#include <regex>
#include "Boot.h"
#include "Service.h"

int main(int argc, char **argv) {
    if (argc != 2) {
        std::cout << "Usage: " << argv[0] << " <inputFile>" << std::endl;
    }
    // Boot and Service Name array
    std::vector<Boot> bootArray;
    std::vector<std::string> svcName;
    // Map of services <service_name, Service class>
    std::unordered_map<std::string, Service> services;

    int startCount = 0, lineNum = 0, complCount = 0;
    bool starting = false;
    std::string line, filename = argv[1];
    std::string outfilename = filename + ".rpt";
    std::string dt, tm;
    std::smatch sm;

    std::regex e_start("(\\S*) (.*)log.c.166(.*)server started(.*)");
    std::regex e_compl("(\\S*) (.*)oejs.AbstractConnector:Started " \
                         "SelectChannelConnector(.*)");
    std::regex e_svcstart("Starting Service.(\\s*)(\\S*) (.*)");
    std::regex e_svccompl("Service started successfully.(\\s*)(\\S*) " \
                            "(\\S*) (.)(\\S*) (.*)");

    std::ifstream infile(filename);
    std::ofstream outfile(outfilename);

    if (infile.is_open()) {
        while (getline(infile, line)) {
            lineNum++;

            // Boot Start
            if (regex_match(line, sm, e_start)) {
                dt = std::string(sm[1]);
                tm = std::string(sm[2]).substr(0, 8);
                if (bootArray.size() > 0) {  // Service ended after Boot ended
                    Boot curboot = bootArray.back();
                    bootArray.pop_back();
                    curboot.addService(services);
                    curboot.setSvcName(svcName);
                    bootArray.push_back(curboot);
                }
                if (starting) {  // Incomplete boot
                    Boot curboot = bootArray.back();
                    bootArray.pop_back();
                    curboot.addService(services);
                    curboot.setSvcName(svcName);
                    curboot.completed(0, "");
                    bootArray.push_back(curboot);
                }
                Boot boot(filename, lineNum, dt, tm);
                bootArray.push_back(Boot boot(filename, lineNum, dt, tm));
                starting = true;
                startCount++;

            // Boot Completed pattern found
            //} else if (regex_match(line.cbegin(), line.cend(), sm, e_compl)) {
            } else if (regex_match(line, sm, e_compl)) {
                starting = false;
                complCount++;
                tm = std::string(sm[2]).substr(0, 8);

                Boot curboot = bootArray.back();
                bootArray.pop_back();
                curboot.completed(lineNum, tm);
                curboot.addService(services);
                curboot.setSvcName(svcName);
                bootArray.push_back(curboot);

            // Service Started pattern found
            } else if (regex_match(line, sm, e_svcstart)
                       && starting) {
                // Save service name in svcName list, and use it's name and
                // order in the next boot data
                if (services.find(std::string(sm[2])) == services.end()) {
                    svcName.push_back(std::string(sm[2]));
                }
                Service *svc = new Service(std::string(sm[2]), filename,
                                           lineNum);
                services[std::string(sm[2])] = *svc;
                delete svc;

            // Service Completed pattern found
            } else if (regex_match(line, sm, e_svccompl)
                       && services.size() > 0) {
                services[std::string(sm[2])].
                       completed(lineNum, std::stoi(sm[5]));
            }
        }

        // Update the boot data, after the last boot end, just in case
        // there are active services
        if (bootArray.size() > 0) {
            Boot curboot = bootArray.back();
            bootArray.pop_back();
            curboot.addService(services);
            curboot.setSvcName(svcName);
            bootArray.push_back(curboot);
        }

        infile.close();
    } else {
        std::cerr << "Unable to open " << argv[1] << std::endl;
    }

    // Print out the report
    outfile << "Device Boot Report\n" << std::endl;
    outfile << "InTouch log file: " << filename << std::endl;
    outfile << "Line scanned: " << lineNum << std::endl;
    outfile << "\nDevice boot count: initiated = " << startCount;
    outfile << ", completed: " << complCount << "\n\n\n";

    for_each(bootArray.begin(), bootArray.end(), [&](Boot b) {
        outfile << b << std::endl;
    });
    outfile.close();
}

