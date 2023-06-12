CC = g++
EXE = ps7
FLAGS = -Wall -Werror -pedantic -g
DEPS =
OBJS = stdin_boost.o
LIBS = -lboost_regex
all: $(EXE)

$(EXE): $(OBJS) $(LIBS)    
	$(CC) $(FLAGS) -o $@  $^
%.o : %.cpp
	$(CC) -c $^
clean:
	rm $(EXE) $(OBJS)