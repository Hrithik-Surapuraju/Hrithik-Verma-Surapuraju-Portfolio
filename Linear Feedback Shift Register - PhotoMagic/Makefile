CC = g++
EXE = photomagic
FLAGS = -Wall -Werror -pedantic -g
DEPS = FibLFSR.h
OBJS = PhotoMagic.o FibLFSR.o
LIBS = -lsfml-graphics -lsfml-window -lsfml-system
all: $(EXE)

$(EXE): $(OBJS) $(LIBS)
	$(CC) $(FLAGS) -o $@  $^
%.o : %.cpp
	$(CC) -c $^
clean:
	rm $(EXE) $(OBJS)                          