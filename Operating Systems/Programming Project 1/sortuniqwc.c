#include <stdio.h>
#include <unistd.h>
#include <string.h>
#include <stdlib.h>
#include <sys/wait.h>
#include <sys/types.h>

int main(int argc, char *argv[]) {
  
  int fd1[2], fd2[2], status; 
  pid_t pid;

  if (pipe(fd1)) {
    
    fprintf(stderr, "pipe error\n");
		
    exit(1);
  }

  pid = fork();

  if (pid < 0) {
		
    fprintf(stderr, "fork error\n");

		exit(1);
	}

  if (pid == 0) { 
    
    printf("first child process, run sort: %d\n", getpid());

    dup2(fd1[1], 1);
    close(fd1[0]);
   
    execlp("/usr/bin/sort", "sort", NULL);
		printf("Should not get here after sort.\n");

		exit(1);
  }

	if (pipe(fd2)){
		
    fprintf(stderr, "pipe error\n");
		
    exit(1);
	}

	pid = fork(); 

  if (pid < 0) {
    
    fprintf(stderr, "fork error\n");
		
    exit(1);
  }

  if (pid == 0) { 
    
    dup2(fd1[0], 0);
    dup2(fd2[1], 1);

    close(fd1[1]);
    close(fd2[0]);
   
    execlp("/usr/bin/uniq", "uniq", NULL);
		printf("Should not get here after sort.\n");

		exit(1);
  }

  pid = fork(); 
  if (pid < 0) {

    fprintf(stderr, "fork error\n");

    return 1;
  }

  if (pid == 0) { 
    
    printf("The child process is: %d\n", getpid());

    dup2(fd2[0], 0);
    
    close(fd2[1]);
    close(fd1[0]);
    close(fd1[1]);
    
    execlp("/usr/bin/wc", "wc", "-l", NULL);
		printf("Should not be here after execlp to wc -l.\n");

		exit(1);
  }

  close(fd1[0]);
  close(fd1[1]);
  close(fd2[0]);
  close(fd2[1]);

  waitpid(pid, &status, 0);

  printf("The child process running wc -l is %d\n", pid);
  return 0;
}
