{
  inputs = {
    nixpkgs.url = "github:cachix/devenv-nixpkgs/rolling";
    systems.url = "github:nix-systems/default";
    devenv.url = "github:cachix/devenv";
    devenv.inputs.nixpkgs.follows = "nixpkgs";
  };

  nixConfig = {
    extra-trusted-public-keys = "devenv.cachix.org-1:w1cLUi8dv3hnoSPGAuibQv+f9TZLr6cv/Hm9XgU50cw=";
    extra-substituters = "https://devenv.cachix.org";
  };

  outputs = { self, nixpkgs, devenv, systems, ... } @ inputs:
    let
      forEachSystem = nixpkgs.lib.genAttrs (import systems);
    in
    {
      packages = forEachSystem (system: {
        devenv-up = self.devShells.${system}.default.config.procfileScript;
      });

      devShells = forEachSystem
        (system:
          let
            pkgs = nixpkgs.legacyPackages.${system};
          in
          {
            default = devenv.lib.mkShell {
              inherit inputs pkgs;
              modules = [
                {
                  # packages = with pkgs; [
                  #   mysql-workbench
                  # ];

                  languages.php = {
                    enable = true;
                    version = "8.1";
                  };

                  services.mysql = {
                    enable = true;
                    package = pkgs.mariadb;
                    initialDatabases = [{ name = "qual_pei"; }];
                    ensureUsers = [
                      {
                        name = "root";
                        password = "";
                        ensurePermissions = { "root.*" = "ALL PRIVILEGES"; };
                      }
                    ];
                    settings = {
                      mysqld = {
                        "bind_address" = "localhost";
                      };
                    };
                  };

                  scripts = {
                    EnvClearAll.exec = "rm -rf ./.devenv ./.direnv";
                    EnvClearStatic.exec = "rm -rf ./.devenv/state";
                  };
                }
              ];
            };
          });
    };
}
