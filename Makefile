CC = g++
EXE = KRONOS
FLAGS = -Wall -Werror -pedantic -g
DEPS = Service.h Boot.h
OBJS = Service.o Boot.o Kronos.o
LIBS = -lboost_regex -lboost_date_time
all: $(EXE)

$(EXE): $(OBJS) $(LIBS)
	$(CC) $(FLAGS) -o $@  $^
%.o : %.cpp
	$(CC) -c $^
clean:
	rm $(EXE) $(OBJS)    
